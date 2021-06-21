<?php
//609444 test
require __DIR__."/vendor/autoload.php";

use MyStore2\App;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try{
    $app = new App();
    $app->run();
}
catch (Exception $e){
    echo $e->getMessage()."\n";
    file_put_contents($_ENV['MAIN_LOG_PATH'], date('Y-m-d H:i:s')." ### ".$e->getMessage()."\n\n", FILE_APPEND);
}