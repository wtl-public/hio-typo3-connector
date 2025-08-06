<?php

namespace Wtl\HioTypo3Connector\Reaction;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use TYPO3\CMS\Reactions\Model\ReactionInstruction;
use TYPO3\CMS\Reactions\Reaction\ReactionInterface;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructureDto;
use Wtl\HioTypo3Connector\Event\ReceiveHioResearchInfrastructureEvent;

class ReceiveHioResearchInfrastructuresReaction implements ReactionInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface   $responseFactory,
        private readonly StreamFactoryInterface     $streamFactory,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public static function getType(): string
    {
        return 'receive-hio-researchinfrastructures';
    }

    public static function getDescription(): string
    {
        return 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/researchInfrastructure.xlf:receive-hio-researchinfrastructures_reaction';
    }

    public static function getIconIdentifier(): string
    {
        return 'tx-hio_typo3_connector-researchinfrastructures';
    }

    public function react(
        ServerRequestInterface $request,
        array                  $payload,
        ReactionInstruction    $reaction
    ): ResponseInterface
    {

        if (is_array($payload['data'] ?? false)) {
            $storagePid = (int)($reaction->toArray()['storage_pid'] ?? 0);
            foreach ($payload['data'] as $value) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioResearchInfrastructureEvent(
                        ResearchInfrastructureDto::fromArray($value),
                        $storagePid
                    )
                );
            }
        }
        return $this->createJsonResponse(['status' => 'Research infrastructures imported']);
    }

    private function createJsonResponse(array $data, int $statusCode = 201): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse($statusCode)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode($data, JSON_THROW_ON_ERROR)));
    }
}
