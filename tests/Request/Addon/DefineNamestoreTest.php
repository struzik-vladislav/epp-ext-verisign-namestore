<?php

namespace Struzik\EPPClient\Extension\Verisign\Namestore\Tests\Request\Addon;

use Struzik\EPPClient\Extension\Verisign\Namestore\Request\Addon\DefineNamestore;
use Struzik\EPPClient\Extension\Verisign\Namestore\Tests\NamestoreTestCase;
use Struzik\EPPClient\Request\Domain\CheckDomainRequest;

class DefineNamestoreTest extends NamestoreTestCase
{
    public function testCheckDomainRequest(): void
    {
        $expected = <<<'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <command>
    <check>
      <domain:check xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
        <domain:name>EXAMPLE1.TLD</domain:name>
        <domain:name>EXAMPLE2.TLD</domain:name>
        <domain:name>EXAMPLE3.TLD</domain:name>
      </domain:check>
    </check>
    <extension>
      <namestoreExt:namestoreExt xmlns:namestoreExt="http://www.verisign-grs.com/epp/namestoreExt-1.1">
        <namestoreExt:subProduct>TLD</namestoreExt:subProduct>
      </namestoreExt:namestoreExt>
    </extension>
    <clTRID>TEST-REQUEST-ID</clTRID>
  </command>
</epp>

EOF;
        $request = new CheckDomainRequest($this->eppClient);
        $request->addDomain('EXAMPLE1.TLD');
        $request->addDomain('EXAMPLE2.TLD');
        $request->addDomain('EXAMPLE3.TLD');
        $request->addExtAddon(new DefineNamestore('TLD'));
        $request->build();

        $this->assertSame($expected, $request->getDocument()->saveXML());
    }
}
