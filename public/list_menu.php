<?php

require_once '../vendor/autoload.php';
require_once '../app/Import/BrowserImport.php';
require_once '../app/Database/DatabaseManager.php';

use App\Import\BrowserImport;
use App\Database\DatabaseManager;

$mysql = new DatabaseManager(include '../app/Database/config.php');
$mysql->createPDO();

$menu = BrowserImport::execute($mysql);


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
foreach ($menu as $item) {
    echo $item . '<br />';
}
?>
</body>
</html>
