<?php

use Mews\Pos\Exceptions\BankClassNullException;
use Mews\Pos\Exceptions\BankNotFoundException;
use Mews\Pos\Factory\AccountFactory;
use Mews\Pos\Factory\PosFactory;
use Symfony\Component\HttpFoundation\Request;

require '../../_main_config.php';

$path = '/ykb/3d/';
$baseUrl = $hostUrl.$path;

$successUrl = $failUrl = $baseUrl.'response.php';


/* Banka Adı : yapikredi ,Üye işyeri no (MID), USERNAME(BOŞ BIRAKIN), PASSWORD (BOŞ BIRAKIN), Terminal no (TID), Posnet no, Regular/Payment, STOREKEY (aşağıdakiler test ortamı için geçerli productionda güncellenmeli) */

$account = AccountFactory::createPosNetAccount('yapikredi', 'XXXXXX', 'XXXXXX', 'XXXXXX', 'XXXXXX', 'XXXXXX', '3d', '10,10,10,10,10,10,10,10');

$request = Request::createFromGlobals();
$ip = $request->getClientIp();

try {
    $pos = PosFactory::createPosGateway($account);
    /* True: test ortamı, False: production ortamına alır */
    $pos->setTestMode(true);
} catch (BankNotFoundException $e) {
    dump($e->getCode(), $e->getMessage());
} catch (BankClassNullException $e) {
    dump($e->getCode(), $e->getMessage());
}

$templateTitle = '3D Model Payment';
