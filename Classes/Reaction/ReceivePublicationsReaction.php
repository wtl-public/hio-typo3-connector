<?php

namespace Wtl\HioTypo3Connector\Reaction;

use TYPO3\CMS\Reactions\Reaction\ReactionInterface;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;

class ReceivePublicationsReaction implements ReactionInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly PublicationRepository $publicationRepository,
    )
    {
    }

    public static function getType(): string
    {
        return 'receive-publications_reaction';
    }

    public static function getDescription(): string
    {
        return 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:receive-publications_reaction';
    }

    public static function getIconIdentifier(): string
    {
        return 'tx-hio_typo3_connector-publications';
    }

    public function react(
        ServerRequestInterface $request,
        array $payload,
        ReactionInstruction $reaction
    ): ResponseInterface {

        if (is_array($payload['data'] ?? false)) {
            $storagePid = (int)($reaction->toArray()['storage_pid'] ?? 0);
            $this->publicationRepository->savePublications($payload['data'], $storagePid);
        }
        return $this->createJsonResponse(['status' => 'Publications imported']);
    }
}
