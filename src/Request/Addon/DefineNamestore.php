<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore\Request\Addon;

use Struzik\EPPClient\Extension\RequestAddonInterface;
use Struzik\EPPClient\Extension\Verisign\Namestore\Node\NamestoreExtNode;
use Struzik\EPPClient\Extension\Verisign\Namestore\Node\SubProductNode;
use Struzik\EPPClient\Node\Common\ExtensionNode;
use Struzik\EPPClient\Request\RequestInterface;

class DefineNamestore implements RequestAddonInterface
{
    private string $subProduct;

    public function __construct(string $subProduct)
    {
        $this->subProduct = $subProduct;
    }

    public function build(RequestInterface $request): void
    {
        $extensionNode = ExtensionNode::create($request);
        $namestoreExtNode = NamestoreExtNode::create($request, $extensionNode);
        SubProductNode::create($request, $namestoreExtNode, $this->subProduct);
    }
}
