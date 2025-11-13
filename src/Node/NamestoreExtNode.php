<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore\Node;

use Struzik\EPPClient\Exception\UnexpectedValueException;
use Struzik\EPPClient\Extension\Verisign\Namestore\NamestoreExtension;
use Struzik\EPPClient\Request\RequestInterface;

class NamestoreExtNode
{
    public static function create(RequestInterface $request, \DOMElement $parentNode): \DOMElement
    {
        $namespace = $request->getClient()
            ->getExtNamespaceCollection()
            ->offsetGet(NamestoreExtension::NS_NAME_NAMESTORE);
        if (!$namespace) {
            throw new UnexpectedValueException('URI of the Namestore Mapping namespace cannot be empty.');
        }

        $node = $request->getDocument()->createElement('namestoreExt:namestoreExt');
        $node->setAttribute('xmlns:namestoreExt', $namespace);
        $parentNode->appendChild($node);

        return $node;
    }
}
