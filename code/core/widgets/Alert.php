<?php

namespace Core\Widgets;

use Core\Base\Session;

class Alert
{
    const FLASH = 'FLASH_MESSAGES';

    const FLASH_ERROR = 'danger';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

    /**
     * @param string $name
     * @return void
     */
    public function flash(string $name) :void
    {
        if (!$this->has($name)) {
            return;
        }

        $flash_message = $_SESSION[self::FLASH][$name];

        unset($_SESSION[self::FLASH][$name]);

        echo $this->formatFlashMessage($flash_message);
    }

    /**
     * @return void
     */
    public function allFlash() :void
    {
        if (!isset($_SESSION[self::FLASH])) {
            return;
        }

        $flash_messages = $_SESSION[self::FLASH];

        unset($_SESSION[self::FLASH]);

        foreach ($flash_messages as $flash_message) {
            echo $this->formatFlashMessage($flash_message);
        }
    }

    /**
     * @param string $name
     * @param string $message
     * @param string $type
     * @return void
     */
    public function setFlashMessage(string $name, string $message, string $type) :void
    {
        if (isset($_SESSION[self::FLASH][$name])) {
            unset($_SESSION[self::FLASH][$name]);
        }

        $_SESSION[self::FLASH][$name] = ['message' => $message, 'type' => $type];
    }

    /**
     * @param string $name
     * @return mixed|void
     */
    public function getFlashMessage(string $name)
    {
        if ($this->has($name)) {
            return $_SESSION[self::FLASH][$name];
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name) :bool
    {
        return isset($_SESSION[self::FLASH][$name]);
    }

    /**
     * @param array $message
     * @return string
     */
    private function formatFlashMessage(array $message): string
    {
        return sprintf('<div class="alert alert-%s" role="alert">%s</div>',
            $message['type'],
            $message['message']
        );
    }
}