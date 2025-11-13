<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore\Response\Addon;

use Struzik\EPPClient\Response\ResponseInterface;

/**
 * Object representation of the add-on for namestore data.
 */
class NamestoreInfo
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getSubProduct(): string
    {
        return $this->response
            ->getFirst('//epp:epp/epp:response/epp:extension/namestoreExt:namestoreExt/namestoreExt:subProduct')
            ->nodeValue;
    }
}
