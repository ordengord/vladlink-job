<?php

require_once '../vendor/autoload.php';
require_once '../app/Export/JsonParser.php';
require_once '../app/Database/DatabaseManager.php';
require_once '../app/Import/ImportTypeA.php';
require_once '../app/Import/ImportTypeB.php';

use App\Parser\JsonParser;
use App\Database\DatabaseManager;
use App\Import\ImportTypeA;
use App\Import\ImportTypeB;

/* ==============
 * Json Export
 * ============== */

//mb_internal_encoding("UTF-8");

$jsonFile = file_get_contents('categories.json');

$jsonFile = json_decode($jsonFile, true, JSON_UNESCAPED_UNICODE);

$jsonParser = new JsonParser($jsonFile);

$jsonDocument = $jsonParser->parse();

/* ==============
 * Mysql Import
 * ============== */

$mysql = new DatabaseManager(include '../app/Database/config.php');

$mysql->createDatabase();
$mysql->createPDO();
$mysql->setUTF8Encode();
$mysql->createCategoriesTable();

$mysql->insertJsonData($jsonDocument);

/* ==============
 * Type A
 * ============== */

$typeA = ImportTypeA::execute($jsonDocument);

$fileA = fopen('type_a.txt', 'w');

foreach ($typeA as $row) {
    fwrite ($fileA, $row . "\r\n");
}

fclose($fileA);

/* ==============
 * Type B
 * ============== */

$typeB = ImportTypeB::execute($jsonDocument);

$fileB = fopen('type_b.txt', 'w');

foreach ($typeB as $row) {
    fwrite ($fileB, $row . "\r\n");
}

fclose($fileB);
