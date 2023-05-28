<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw7;

class ConfigProvider {

    private const CONFIG_FILE_PATH = 'config/config.ini';

    private array $_config = [];

    /**
     * 
     */
    public function __construct() {
        $this->_config = parse_ini_file(self::CONFIG_FILE_PATH);
    }

    /**
     * 
     * @param string $field_name
     * @return string|false
     */
    public function get_field(string $field_name = ''): string|false {
        $field_value = !empty($this->_config[$field_name]) ? $this->_config[$field_name] : false;
        return $field_value;
    }

}
