<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore\Tests\Response\Addon;

use Struzik\EPPClient\Extension\Verisign\Namestore\Response\Addon\NamestoreError;
use Struzik\EPPClient\Extension\Verisign\Namestore\Tests\NamestoreTestCase;
use Struzik\EPPClient\Response\Domain\CheckDomainResponse;

class NamestoreErrorTest extends NamestoreTestCase
{
    public function testCheckDomainResponse(): void
    {
        $xml = <<<'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <response>
    <result code="2306">
      <msg>Parameter value policy error</msg>
    </result>
    <extension>
      <namestoreExt:nsExtErrData xmlns:namestoreExt="http://www.verisign-grs.com/epp/namestoreExt-1.1">
        <namestoreExt:msg code="1">Invalid sub-product</namestoreExt:msg>
      </namestoreExt:nsExtErrData>
    </extension>
    <trID>
      <clTRID>ABC-12345</clTRID>
      <svTRID>54321-XYZ</svTRID>
    </trID>
  </response>
</epp>
EOF;
        $response = new CheckDomainResponse($xml, $this->eppClient->getNamespaceCollection(), $this->eppClient->getExtNamespaceCollection());
        $this->namestoreExtension->handleResponse($response);
        $this->assertFalse($response->isSuccess());
        $this->assertInstanceOf(NamestoreError::class, $response->findExtAddon(NamestoreError::class));

        /** @var NamestoreError $namestoreError */
        $namestoreError = $response->findExtAddon(NamestoreError::class);
        $this->assertSame('Invalid sub-product', $namestoreError->getErrorMessage());
        $this->assertSame('1', $namestoreError->getErrorCode());
    }
}
