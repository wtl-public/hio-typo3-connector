<?php

declare(strict_types=1);

/**
 * Standalone regression checks using connection-local temporary tables only.
 * Run from the TYPO3 project root: ddev exec php vendor/wtl/hio-typo3-connector/Tests/Integration/ImportCompatibility.php
 * Optional HIO_TEST_DB_* variables override the DDEV defaults.
 */
require getcwd() . '/vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Command\PublicationsImportCommand;
use Wtl\HioTypo3Connector\Domain\Model\Publication;
use Wtl\HioTypo3Connector\Domain\Repository\BaseRepository;
use Wtl\HioTypo3Connector\Domain\Repository\CitationStyleRepository;
use Wtl\HioTypo3Connector\Publisher\ApiResponse;
use Wtl\HioTypo3Connector\Scheduler\ImportResult;
use Wtl\HioTypo3Connector\Services\HioPublicationService;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleService;
use Wtl\HioTypo3Connector\Utility\NonBmpNormalizer;

function check(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
    echo "OK: $message\n";
}

final class TemporaryTableConnection extends Connection
{
    protected function ensureDatabaseValueTypes(string $tableName, array &$data, array &$types): void
    {
        // This standalone test uses temporary tables and supplies scalar values directly.
    }
}

$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql', 'host' => getenv('HIO_TEST_DB_HOST') ?: 'db',
    'user' => getenv('HIO_TEST_DB_USER') ?: 'db', 'password' => getenv('HIO_TEST_DB_PASSWORD') ?: 'db',
    'dbname' => getenv('HIO_TEST_DB_NAME') ?: 'db', 'charset' => 'utf8mb4', 'wrapperClass' => TemporaryTableConnection::class,
]);
$pool = new class($connection) extends ConnectionPool {
    public function __construct(private Connection $connection) {}
    public function getConnectionForTable(string $tableName): Connection { return $this->connection; }
};
$repository = (new ReflectionClass(BaseRepository::class))->newInstanceWithoutConstructor();
$prepare = new ReflectionMethod(BaseRepository::class, 'prepareImportData');
$title = 'GL(𝑛,𝑞) 😀 ä ﬁ';
check(NonBmpNormalizer::normalize($title) === 'GL(n,q)  ä ﬁ', 'normalize only non-BMP characters');
foreach (['utf8mb3' => 'utf8mb3_unicode_ci', 'utf8mb4' => 'utf8mb4_general_ci'] as $charset => $collation) {
    $table = 'hio_test_' . $charset;
    $connection->executeStatement("CREATE TEMPORARY TABLE $table (title TEXT, search_index TEXT, slug VARCHAR(255), details BLOB) CHARACTER SET $charset COLLATE $collation");
    $data = ['object_id' => 6587, 'title' => $title, 'search_index' => $title, 'slug' => 'gl-𝑛-𝑞', 'details' => json_encode(['title' => $title], JSON_UNESCAPED_UNICODE)];
    $prepared = $prepare->invoke($repository, $table, $data);
    $expected = NonBmpNormalizer::normalize($title);
    check($prepared['title'] === $expected && $prepared['search_index'] === $expected, "$charset storage values");
    check($prepared['details'] === $data['details'], "$charset preserves original details");
    check($prepared['slug'] === 'gl-n-q', "$charset normalizes supplied slug");
    unset($prepared['object_id']);
    $connection->executeStatement("INSERT INTO $table (title, search_index, slug, details) VALUES (?, ?, ?, ?)", array_values($prepared));
    check($connection->fetchOne("SELECT title FROM $table") === $expected, "$charset actual INSERT");
    check(json_decode($connection->fetchOne("SELECT details FROM $table"), true)['title'] === $title, "$charset original title survives database round trip");
    $connection->executeStatement("DROP TEMPORARY TABLE $table");
}
// Preparation no longer depends on a database connection or existing table.
$prepared = $prepare->invoke($repository, 'hio_test_without_table', $data);
check($prepared['title'] === NonBmpNormalizer::normalize($title), 'preparation needs no database probe');
check(NonBmpNormalizer::normalize('ä é 中 ﬁ') === 'ä é 中 ﬁ', 'BMP characters remain unchanged');
check($prepare->invoke($repository, 'hio_test_without_table', $prepared) === $prepared, 'preparation is idempotent');

$slugHelper = new class extends \TYPO3\CMS\Core\DataHandling\SlugHelper {
    public function __construct() {}
    public function generate(array $recordData, int $pid): string {
        check($recordData['title'] === 'GL(n,q)', 'slug source normalized before generation');
        return 'gl(n,q)';
    }
    public function buildSlugForUniqueInSite(string $slug, \TYPO3\CMS\Core\DataHandling\Model\RecordState $state): string {
        check($slug === 'gl(n,q)', 'uniqueness check receives normalized slug');
        return $slug;
    }
};
GeneralUtility::addInstance(\TYPO3\CMS\Core\DataHandling\SlugHelper::class, $slugHelper);
$GLOBALS['TCA']['hio_test_slug']['columns']['slug']['config']['eval'] = 'uniqueInSite';
$repository->injectSlugHelperFactory(new \Wtl\HioTypo3Connector\DataHandling\SlugHelperFactory());
$generate = new ReflectionMethod(BaseRepository::class, 'generateSlug');
check($generate->invoke($repository, 'hio_test_slug', 'slug', ['title' => 'GL(𝑛,𝑞)'], 1) === 'gl(n,q)', 'normalized slug independent of table charset');

$publication = new Publication();
$publication->setTitle('fallback');
check($publication->getTitle() === 'fallback', 'title getter returns stored column');
check($publication->getDetailsTitle() === 'fallback', 'details title falls back without details');
$publication->setDetails(['title' => $title]);
check($publication->getTitle() === 'fallback', 'details do not override title getter');
check($publication->getDetails()['title'] === $title, 'original title available explicitly through details');
check($publication->getDetailsTitle() === $title, 'details title returns original title');
foreach ([[], ['title' => null], ['title' => ''], ['title' => 42]] as $details) {
    $publication->setDetails($details);
    check($publication->getDetailsTitle() === 'fallback', 'details title falls back for missing, empty or invalid title');
}


$service = new class extends HioPublicationService {
    public bool $withInvalidPublication = false;
    public bool $failSecondPage = false;

    public function __construct() {}
    public function configure(string $url, string $username, string $password, string $storagePageId, bool $verifySsl, bool $disableBasicAuth = false): void {}
    public function fetch($page = 1): ApiResponse
    {
        if ($page === 2 && $this->failSecondPage) {
            throw new RuntimeException('Simulated API failure on page 2');
        }
        $rows = array_map(
            static fn(int $id): array => ['id' => $id, 'publicationType' => ['id' => 1]],
            $page === 1 ? [1, 2, 3] : [4]
        );
        if ($page === 1 && $this->withInvalidPublication) {
            unset($rows[1]['publicationType']);
            $rows[1]['lastSeenAt'] = '2026-01-10T08:00:00+00:00';
            $rows[2]['lastSeenAt'] = $rows[1]['lastSeenAt'];
        }
        return $this->responseBody = new ApiResponse($rows, [$page, 1, 2, [], '', 3, 4, 4], []);
    }
};
$dispatcher = new class implements EventDispatcherInterface {
    public array $ids = [];
    public ?int $failId = 2;
    public function dispatch(object $event): object {
        $id = $event->getHioPublication()->getObjectId();
        $this->ids[] = $id;
        if ($id === $this->failId) {
            throw new RuntimeException('Simulated storage failure');
        }
        return $event;
    }
};
$citations = new class extends CitationStyleRepository {
    public function __construct() {}
    public function saveCitationStyles(array $citations): void {}
};
$command = new class($service, $citations, $dispatcher, new RecordLifecycleService($pool)) extends PublicationsImportCommand {
    protected function configure(): void {
        foreach (['endpoint', 'storagePageId', 'username', 'password'] as $argument) {
            $this->addArgument($argument, \Symfony\Component\Console\Input\InputArgument::OPTIONAL, '', '');
        }
        foreach (['verify-ssl', 'no-basic-auth', 'with-trashed', 'soft-delete-after-days', 'hard-delete-after-days'] as $option) {
            $this->addOption($option);
        }
    }
};
$importResult = GeneralUtility::makeInstance(ImportResult::class);
$importResult->begin();
$output = new BufferedOutput();
try {
    $command->run(new ArrayInput(['endpoint' => 'https://example.invalid', 'storagePageId' => '1']), $output);
    throw new LogicException('Partial import failure did not throw');
} catch (RuntimeException $exception) {
    check($exception->getCode() === 1, 'partial failure exception carries nonzero exit code');
    check(str_contains($exception->getMessage(), '1 Publications failed to import')
        && str_contains($exception->getMessage(), 'tx_hiotypo3connector_domain_model_publication')
        && str_contains($exception->getMessage(), 'Failed object IDs: 2'), 'scheduler exception reports failure count, table and IDs');
}
check(
    $importResult->end() === ['imported' => 3, 'failed' => 1, 'completed' => true],
    'a completed import retains its counts even when it reports record failures'
);
$text = $output->fetch();
check($dispatcher->ids === [1, 2, 3, 4], 'import continues after failed record');
check(str_contains($text, '3 Publications imported successfully') && str_contains($text, '1 Publications failed') && str_contains($text, 'Failed object IDs: 2'), 'summary reports successes, failures and IDs');

try {
    $command->run(
        new ArrayInput(['endpoint' => 'https://example.invalid', 'storagePageId' => '1']),
        new \Symfony\Component\Console\Output\NullOutput()
    );
    throw new LogicException('Scheduler-style execution lost the failure');
} catch (RuntimeException $exception) {
    check(str_contains($exception->getMessage(), 'Failed object IDs: 2'), 'IDs remain available with scheduler NullOutput');
}

$publicationTable = 'tx_hiotypo3connector_domain_model_publication';
$connection->executeStatement("CREATE TEMPORARY TABLE $publicationTable (
    uid INT PRIMARY KEY, pid INT, object_id INT, hidden INT, deleted INT, soft_deleted_at INT, last_seen_at INT, tstamp INT
)");
$softDeletedAt = strtotime('2026-01-05T00:00:00+00:00');
$connection->executeStatement(
    "INSERT INTO $publicationTable VALUES (2, 1, 2, 1, 0, ?, 0, 0), (3, 1, 3, 1, 0, ?, 0, 0)",
    [$softDeletedAt, $softDeletedAt]
);

$dispatcher->failId = null;
$dispatcher->ids = [];
$service->withInvalidPublication = true;
$output = new BufferedOutput();
try {
    $command->run(new ArrayInput(['endpoint' => 'https://example.invalid', 'storagePageId' => '1']), $output);
    throw new LogicException('Mapping failure did not fail the run');
} catch (RuntimeException $exception) {
    check($exception->getCode() === 1 && str_contains($exception->getMessage(), 'Failed object IDs: 2'), 'mapping failure is reported with its object ID');
}
check($dispatcher->ids === [1, 3, 4], 'valid publications on the same page and the next page are dispatched');
check(str_contains($output->fetch(), '3 Publications imported successfully'), 'summary counts only mapped and dispatched publications as successful');

$invalidPublication = $connection->fetchAssociative("SELECT * FROM $publicationTable WHERE uid = 2");
check(
    (int)$invalidPublication['hidden'] === 1 && (int)$invalidPublication['soft_deleted_at'] === $softDeletedAt,
    'a publication with a mapping failure remains hidden'
);
check(
    (int)$invalidPublication['last_seen_at'] === strtotime('2026-01-10T08:00:00+00:00'),
    'a publication with a mapping failure is still recorded as seen'
);
$validPublication = $connection->fetchAssociative("SELECT * FROM $publicationTable WHERE uid = 3");
check(
    (int)$validPublication['hidden'] === 0 && (int)$validPublication['soft_deleted_at'] === 0,
    'a valid publication on the same page is restored'
);

$service->withInvalidPublication = false;
$output = new BufferedOutput();
$code = $command->run(new ArrayInput(['endpoint' => 'https://example.invalid', 'storagePageId' => '1']), $output);
$text = $output->fetch();
check($code === 0 && str_contains($text, '4 Publications imported successfully') && str_contains($text, '0 Publications failed'), 'successful run returns zero and resets failure state');

$service->withInvalidPublication = true;
$service->failSecondPage = true;
$importResult->begin();
try {
    $command->run(
        new ArrayInput(['endpoint' => 'https://example.invalid', 'storagePageId' => '1']),
        new \Symfony\Component\Console\Output\NullOutput()
    );
    throw new LogicException('The second-page failure did not abort the import');
} catch (RuntimeException $exception) {
    check($exception->getMessage() === 'Simulated API failure on page 2', 'the original API failure reaches the caller');
}
check(
    $importResult->end() === ['imported' => 2, 'failed' => 1, 'completed' => false],
    'an aborted import retains successes and failures from the processed page'
);
