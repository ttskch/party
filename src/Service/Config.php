<?php
declare(strict_types=1);

namespace Ttskch\Party\Service;

use Cake\Utility\Hash;
use Symfony\Component\Yaml\Yaml;

class Config
{
    const DEFAULT_CONFIG_FILE_PATH_UNDER_HOME_DIR = '/.config/party/config.yaml';

    /**
     * @var string
     */
    private $configFilePath;

    /**
     * @var array
     */
    private $config;

    public function __construct(string $configFilePath = null)
    {
        $this->configFilePath = $configFilePath ?: $_SERVER['HOME'] . self::DEFAULT_CONFIG_FILE_PATH_UNDER_HOME_DIR;
        $this->config = Yaml::parseFile($this->configFilePath);
    }

    public function getConfig(string $dotSeparatedKey)
    {
        return Hash::get($this->config, $dotSeparatedKey);
    }

    public function getUnitPrice(string $dotSeparatedKeys)
    {
        $currency = $this->getConfig('currency');
        $unitPrices = Yaml::parseFile(__DIR__ . "/../../config/unit_prices/{$currency}.yaml");

        return Hash::get($unitPrices, $dotSeparatedKeys);
    }

    public static function createDefaultConfigFile(): void
    {
        @mkdir(dirname($_SERVER['HOME'] . self::DEFAULT_CONFIG_FILE_PATH_UNDER_HOME_DIR), 0644, true);
        @copy(__DIR__ . '/../../config/config.yaml.dist', $_SERVER['HOME'] . self::DEFAULT_CONFIG_FILE_PATH_UNDER_HOME_DIR);

        echo sprintf('"%s" is created. Modify it if you need.', $_SERVER['HOME'] . self::DEFAULT_CONFIG_FILE_PATH_UNDER_HOME_DIR) . PHP_EOL;
    }
}
