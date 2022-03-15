<?php
declare(strict_types=1);
use App\Controllers\CalculateController;

require_once realpath("vendor/autoload.php");
require ("src/helpers.php");

$changer = new CalculateController();

try {
    $changer->calculateCommission(fopen($argv[1],'r'));
} catch (Exception $e) {
    return $e->getMessage();
}
