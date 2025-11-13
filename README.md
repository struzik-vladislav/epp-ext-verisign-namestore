# Verisign Namestore Extension Mapping for EPP Client
![Build Status](https://github.com/struzik-vladislav/epp-ext-verisign-namestore/actions/workflows/ci.yml/badge.svg?branch=main)
[![Latest Stable Version](https://img.shields.io/github/v/release/struzik-vladislav/epp-ext-verisign-namestore?sort=semver&style=flat-square)](https://packagist.org/packages/struzik-vladislav/epp-ext-verisign-namestore)
[![Total Downloads](https://img.shields.io/packagist/dt/struzik-vladislav/epp-ext-verisign-namestore?style=flat-square)](https://packagist.org/packages/struzik-vladislav/epp-ext-verisign-namestore/stats)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![StandWithUkraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

NameStore extension provided by [Verisign](https://www.verisign.com/). See [original documentation](https://www.verisign.com/assets/epp-sdk/verisign_epp-extension_namestoreext_v01.html).

Extension for [struzik-vladislav/epp-client](https://github.com/struzik-vladislav/epp-client) library.


## Usage
```php
<?php

use Psr\Log\NullLogger;
use Struzik\EPPClient\EPPClient;
use Struzik\EPPClient\Extension\Verisign\Namestore\NamestoreExtension;
use Struzik\EPPClient\Extension\Verisign\Namestore\Request\Addon\DefineNamestore;
use Struzik\EPPClient\Extension\Verisign\Namestore\Response\Addon\NamestoreError;
use Struzik\EPPClient\Extension\Verisign\Namestore\Response\Addon\NamestoreInfo;
use Struzik\EPPClient\Request\Domain\CheckDomainRequest;

// ...

$client->pushExtension(new NamestoreExtension('http://www.verisign-grs.com/epp/namestoreExt-1.1', new NullLogger()));

// ...

$request = new CheckDomainRequest($client);
$request->addDomain('example.com');
$request->addExtAddon(new DefineNamestore('dotCOM'));
$response = $client->send($request);

$namestoreInfo = $response->findExtAddon(NamestoreInfo::class);
if ($namestoreInfo instanceof NamestoreInfo) {
    $subProduct = $namestoreInfo->getSubProduct();
}

$namestoreError = $response->findExtAddon(NamestoreError::class);
if ($namestoreError instanceof NamestoreError) {
    $errorMessage = $namestoreError->getErrorMessage();
    $errorCode = $namestoreError->getErrorCode();
}
```
