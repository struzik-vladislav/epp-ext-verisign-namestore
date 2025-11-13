<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore;

use Psr\Log\LoggerInterface;
use Struzik\EPPClient\EPPClient;
use Struzik\EPPClient\Extension\ExtensionInterface;
use Struzik\EPPClient\Extension\Verisign\Namestore\Response\Addon\NamestoreError;
use Struzik\EPPClient\Extension\Verisign\Namestore\Response\Addon\NamestoreInfo;
use Struzik\EPPClient\Response\ResponseInterface;

/**
 * Extension for the Verisign Namestore.
 */
class NamestoreExtension implements ExtensionInterface
{
    public const NS_NAME_NAMESTORE = 'namestoreExt';

    private string $uri;
    private LoggerInterface $logger;

    /**
     * @param string $uri URI of the Verisign Namestore extension
     */
    public function __construct(string $uri, LoggerInterface $logger)
    {
        $this->uri = $uri;
        $this->logger = $logger;
    }

    public function setupNamespaces(EPPClient $client): void
    {
        $client->getExtNamespaceCollection()
            ->offsetSet(self::NS_NAME_NAMESTORE, $this->uri);
    }

    public function handleResponse(ResponseInterface $response): void
    {
        if (!in_array($this->uri, $response->getUsedNamespaces(), true)) {
            $this->logger->debug(sprintf(
                'Namespace with URI "%s" does not exists in used namespaces of the response object.',
                $this->uri
            ));

            return;
        }

        $node = $response->getFirst('//namestoreExt:namestoreExt');
        if ($node !== null) {
            $this->logger->debug(sprintf('Adding add-on "%s" to the response object.', NamestoreInfo::class));
            $response->addExtAddon(new NamestoreInfo($response));
        }
        $node = $response->getFirst('//namestoreExt:nsExtErrData');
        if ($node !== null) {
            $this->logger->debug(sprintf('Adding add-on "%s" to the response object.', NamestoreError::class));
            $response->addExtAddon(new NamestoreError($response));
        }
    }
}
