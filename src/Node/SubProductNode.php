<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore\Node;

use Struzik\EPPClient\Exception\InvalidArgumentException;
use Struzik\EPPClient\Request\RequestInterface;

class SubProductNode
{
    public static function create(RequestInterface $request, \DOMElement $parentNode, string $subProduct): \DOMElement
    {
        if ($subProduct === '') {
            throw new InvalidArgumentException('Invalid parameter "subProduct".');
        }

        $node = $request->getDocument()->createElement('namestoreExt:subProduct');
        $node->appendChild($request->getDocument()->createTextNode($subProduct));
        $parentNode->appendChild($node);

        return $node;
    }
}
