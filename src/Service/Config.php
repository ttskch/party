<?php
declare(strict_types=1);

namespace Ttskch\Party\Service;

use Symfony\Component\Yaml\Yaml;

class Config
{
    const DEFAULT_CONFIG_FILE_PATH_UNDER_HOME_DIR = '/.config/party/config.yaml';
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
        $this->configFilePath = $configFilePath ?: $_SERVER['HOME'] . self::DEFAULT_CONFIG_FILE_PATH_UNDER_HOME_DIR;
        $this->config = Yaml::parseFile($this->configFilePath);
        $this->unitPrices = Yaml::parseFile(__DIR__ . "/../../config/unit_prices/{$this->config['currency']}.yaml");
    }

    public function getUnitPrice(string $key): int
    {
        return (int)$this->unitPrices[$key];
    }

    public function getCupsNumForOneNonAlcohol(): float
    {
        return (float)$this->config['cups_for_one_non_alcohol'];
    }

    public function getBeerPeopleRate(): float
    {
        return $this->config['distribution_rate']['beer'] / array_sum($this->config['distribution_rate']);
    }

    public function getOtherAlcoholPeopleRate(): float
    {
        return $this->config['distribution_rate']['other_alcohol'] / array_sum($this->config['distribution_rate']);
    }

    public function getNonAlcoholPeopleRate(): float
    {
        return $this->config['distribution_rate']['non_alcohol'] / array_sum($this->config['distribution_rate']);
    }

    public function getDrinksNumForOnePizza(): float
    {
        return 1 / ($this->config['pizza_pieces_for_one_drink'] / self::PIZZA_PIECES);
    }

    public function getOnePizzaAndDrinksTotalPriceForOnePizza(): float
    {
        $averagePriceOfOneDrink = array_sum([
            $this->unitPrices['beer'] * $this->getBeerPeopleRate(),
            $this->unitPrices['other_alcohol'] * $this->getOtherAlcoholPeopleRate(),
            ($this->unitPrices['non_alcohol'] / $this->getCupsNumForOneNonAlcohol()) * $this->getNonAlcoholPeopleRate(),
        ]);

        return $this->getDrinksNumForOnePizza() * $averagePriceOfOneDrink + $this->unitPrices['pizza'];
    }


    public static function createDefaultConfigFile(): void
    {
        @mkdir(dirname($path = $_SERVER['HOME'] . self::DEFAULT_CONFIG_FILE_PATH_UNDER_HOME_DIR), 0644, true);

        if (file_exists($path)) {
            echo sprintf('"%s" is already existent. Modify it if you need.', $path) . PHP_EOL;
        } else {
            copy(__DIR__ . '/../../config/config.yaml.dist', $path);
            echo sprintf('"%s" is created. Modify it if you need.', $path) . PHP_EOL;
        }
    }
}
