<?php

declare(strict_types=1);

namespace Ttskch\Party\Service;

use Symfony\Component\Yaml\Yaml;

/**
 * Calculate only from config information (without user input (headcount and budget))
 */
class Config
{
    const DEFAULT_CONFIG_FILE_PATH = __DIR__ . '/../../config/config.yaml.dist';

    const USER_CONFIG_FILE_PATH_UNDER_HOME_DIR = '/.config/party/config.yaml';

    const PIZZA_PIECES = 8;

    /**
     * @var string
     */
    private $configFilePath;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $unitPrices;

    public function __construct(string $configFilePath = null)
    {
        $configFilePath = $configFilePath ?: $_SERVER['HOME'] . self::USER_CONFIG_FILE_PATH_UNDER_HOME_DIR;
        if (! file_exists($configFilePath)) {
            $configFilePath = self::DEFAULT_CONFIG_FILE_PATH;
        }
        $this->configFilePath = $configFilePath;

        $this->config = Yaml::parseFile($this->configFilePath);
        $this->unitPrices = Yaml::parseFile(__DIR__ . "/../../config/unit_prices/{$this->config['currency']}.yaml");
    }

    public function getUnitPrice(string $key) : float
    {
        return (float) $this->unitPrices[$key];
    }

    public function getCupsNumForOneNonAlcohol() : float
    {
        return (float) $this->config['cups_for_one_non_alcohol'];
    }

    public function getPurchaseRates() : array
    {
        $drinksNumForOnePizza = 1 / ($this->config['pizza_pieces_for_one_drink'] / self::PIZZA_PIECES);

        $total = $this->config['distribution_rates']['beer'] + $this->config['distribution_rates']['other_alcohol'] + $this->config['distribution_rates']['non_alcohol'] / $this->config['cups_for_one_non_alcohol'];
        $beerPurchaseRate = ($this->config['distribution_rates']['beer'] / $total) * $drinksNumForOnePizza;
        $otherAlcoholPurchaseRate = ($this->config['distribution_rates']['other_alcohol'] / $total) * $drinksNumForOnePizza;
        $nonAlcoholPurchaseRate = (($this->config['distribution_rates']['non_alcohol'] / $this->config['cups_for_one_non_alcohol']) / $total) * $drinksNumForOnePizza;

        return [
            'pizza' => 1,
            'beer' => $beerPurchaseRate,
            'other_alcohol' => $otherAlcoholPurchaseRate,
            'non_alcohol' => $nonAlcoholPurchaseRate,
        ];
    }
}
