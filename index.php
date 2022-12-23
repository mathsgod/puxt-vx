<?php
require_once __DIR__ . "/vendor/autoload.php";

$app = new PUXT\App();
$app->pipe(VX::class);
$app->run();
