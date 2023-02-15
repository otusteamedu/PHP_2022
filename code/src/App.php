<?php

namespace Ppro\Hw15;

use Ppro\Hw15\Views\ExitView;

class App
{
    const DEFAULT_CONFIG_PATH = __DIR__."/../config.ini";
    const DEFAULT_DB = 'pg';
    const APP_MENU_COMMAND = [
      'FIND_SESSION' => '-f',
      'CHECK_IMAP' => '-c',
      'EXIT' => '-e',
    ];

    private string $configPath;
    private Register $reg;

    /**
     * @param string $customConfigPath
     * @throws \Exception
     */
    public function __construct(string $customConfigPath = "")
    {
        $this->configPath = $customConfigPath ?: self::DEFAULT_CONFIG_PATH;
        $this->reg = Register::instance();
        $this->init();
    }

    /** Запуск приложения
     * @return void
     * @throws \Exception
     */
    public function run(string $customConfigPath = ""): void
    {
        $cmd = Commands\CommandResolver::getCommand();
        $cmd->execute();
    }

    /** Создание объекта конфигурации приложения
     * @return void
     * @throws \Exception
     */
    private function init():void
    {
        $config = new Conf($this->configPath);
        $this->reg->setConfig($config);
        $request = new Request();
        $this->reg->setRequest($request);
        $db = $config->getValue('default','db',self::DEFAULT_DB);
        $this->reg->setValueMulti([
          'db' => $db
        ]);
    }

    /** Переадресация приложения
     * @param string $cmd
     * @return void
     * @throws \Exception
     */
    public static function forward(string $cmd = ''): void
    {
        $_SERVER['argv'][1] = self::APP_MENU_COMMAND[$cmd] ?? '';
        Register::instance()->reset();
        $app = new App();
        $app->run();
    }
}