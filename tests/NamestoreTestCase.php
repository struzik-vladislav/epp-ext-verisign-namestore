<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore\Tests;

use Psr\Log\NullLogger;
use Struzik\EPPClient\Extension\Verisign\Namestore\NamestoreExtension;
use Struzik\EPPClient\Tests\EPPTestCase;

class NamestoreTestCase extends EPPTestCase
{
    public NamestoreExtension $namestoreExtension;

    protected function setUp(): void
    {
        parent::setUp();
        $this->namestoreExtension = new NamestoreExtension('http://www.verisign-grs.com/epp/namestoreExt-1.1', new NullLogger());
        $this->eppClient->pushExtension($this->namestoreExtension);
    }
}
