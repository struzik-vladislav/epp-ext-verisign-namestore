<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore\Tests\Response\Addon;

use Struzik\EPPClient\Extension\Verisign\Namestore\Response\Addon\NamestoreInfo;
use Struzik\EPPClient\Extension\Verisign\Namestore\Tests\NamestoreTestCase;
use Struzik\EPPClient\Response\Domain\CheckDomainResponse;

class NamestoreInfoTest extends NamestoreTestCase
{
    public function testCheckDomainResponse(): void
    {
        $xml = <<<'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <response>
    <result code="1000">
      <msg>Command completed successfully</msg>
    </result>
    <resData>
      <domain:chkData xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
        <domain:cd>
          <domain:name avail="1">EXAMPLE1.TLD</domain:name>
        </domain:cd>
        <domain:cd>
          <domain:name avail="0">EXAMPLE2.TLD</domain:name>
          <domain:reason>In use</domain:reason>
        </domain:cd>
        <domain:cd>
          <domain:name avail="1">EXAMPLE3.TLD</domain:name>
        </domain:cd>
      </domain:chkData>
    </resData>
    <extension>
      <namestoreExt:namestoreExt xmlns:namestoreExt="http://www.verisign-grs.com/epp/namestoreExt-1.1">
         <namestoreExt:subProduct>TLD</namestoreExt:subProduct>
      </namestoreExt:namestoreExt>
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
        $this->assertTrue($response->isSuccess());
        $this->assertInstanceOf(NamestoreInfo::class, $response->findExtAddon(NamestoreInfo::class));

        /** @var NamestoreInfo $namestoreInfo */
        $namestoreInfo = $response->findExtAddon(NamestoreInfo::class);
        $subProduct = $namestoreInfo->getSubProduct();
        $this->assertSame('TLD', $subProduct);
    }
}
