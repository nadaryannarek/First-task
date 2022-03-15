<?php

namespace App\Controllers;

use App\Services\CalculateService;
use Exception;

/**
 * ChangerController
 */
class CalculateController
{
    /**
     * @var mixed
     */
    private $rates;

    /**
     * @var CalculateService
     */
    private CalculateService $calculateService;

    /**
     * @var string
     */
    private string $apiUrl = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';

    /**
     * ChangerController constructor
     */
    function __construct()
    {
        $this->calculateService = new CalculateService();
        $this->rates = json_decode(file_get_contents($this->apiUrl), true);
    }

    /**
     * @param $jsonFile
     * @return void
     * @throws Exception
     */
    public function calculateCommission($jsonFile)
    {
        while (($data = fgetcsv($jsonFile, 1000, ",")) !== FALSE) {
            print $this->calculateService->calculate($data, $this->rates["rates"][$data[5]]) . "\n";
        }
    }
}
