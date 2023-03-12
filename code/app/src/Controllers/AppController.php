<?php

namespace Ppro\Hw27\App\Controllers;

use Ppro\Hw27\App\Application\Registry;
use Ppro\Hw27\App\Application\Request;
use Ppro\Hw27\App\Commands\Command;
use Ppro\Hw27\App\Commands\CommandResolver;
use Ppro\Hw27\App\Commands\DefaultCommand;
use Ppro\Hw27\App\Exceptions\AppException;
use Ppro\Hw27\App\Views\ViewInterface;

class AppController
{
    private static $defaultcmd = DefaultCommand::class;
    private static $defaultview = "main";

    public function getCommand(Request $request): Command
    {
        try {
            $resolver = new CommandResolver();
            $cmd = $resolver->getCommand($request);
        } catch (AppException $e) {
            return new self::$defaultcmd();
        }

        return $cmd;
    }

    public function getView(Request $request): string
    {
        $reg = Registry::instance();
        $views = $reg->getViews();
        $conf = $reg->getConf();
        $path = $request->getPath();

        $templatePath = $conf->get('templatepath') ?? "";

        return $templatePath.($views->get($path) ?? self::$defaultview);
    }

}