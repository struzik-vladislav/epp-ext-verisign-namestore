<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore\Response\Addon;

use Struzik\EPPClient\Response\ResponseInterface;

/**
 * Object representation of the add-on for namestore error.
 */
class NamestoreError
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getErrorMessage(): string
    {
        return $this->response
            ->getFirst('//epp:epp/epp:response/epp:extension/namestoreExt:nsExtErrData/namestoreExt:msg')
            ->nodeValue;
    }

    public function getErrorCode(): string
    {
        return $this->response
            ->getFirst('//epp:epp/epp:response/epp:extension/namestoreExt:nsExtErrData/namestoreExt:msg')
            ->getAttribute('code');
    }
}
