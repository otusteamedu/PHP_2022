<?php

namespace KonstantinDmitrienko\App;

use JsonException;
use KonstantinDmitrienko\App\Controllers\AppController;

/**
 * Base app class
 */
class App
{
    /**
     * @var AppController
     */
    protected AppController $controller;

    public function __construct() {
        $this->controller = new AppController();
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function run(): void
    {
        if (!$_POST) {
            $this->controller->showForm();
            return;
        }

        RequestValidator::validate($_POST);

        switch ($_POST['youtube']['action']) {
            case 'add_channel':
                $this->controller->addYoutubeChannel($_POST['youtube']['name']);
                break;
            case 'get_channels':
                $this->controller->getAllChannelsInfo();
                break;
            case 'get_top_rated_channels':
                $this->controller->getTopRatedChannels();
                break;
        }
    }
}
