<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Application\Viewer\View;
use Otus\App\Application\Controllers\RoutingController;

/**
 * Main app class
 */
class App
{
    /**
     * Runnng app
     * @return void
     */
    public static function run()
    {
        $controller = new RoutingController();
        $controller->index();
    }

    /**
     * Read rabbitMQ config
     * @return false|mixed
     */
    public static function getConfig(): array
    {
        if (!file_exists('/data/mysite.local/src/Config/config.php')) {
            return false;
        } else {
            return include('Config/config.php');
        }
    }

    /**
     * Read mailing config
     * @return false|mixed
     */
    public static function getMailConfig(): array
    {
        if (!file_exists('/data/mysite.local/src/Config/config_mail.php')) {
            return false;
        } else {
            return include('Config/config_mail.php');
        }
    }
}
