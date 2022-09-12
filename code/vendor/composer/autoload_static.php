<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1bd1a9d61171e620984c21c81252050f
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'Otus\\Mvc\\Views\\' => 15,
            'Otus\\Mvc\\Services\\' => 18,
            'Otus\\Mvc\\Models\\' => 16,
            'Otus\\Mvc\\Core\\' => 14,
            'Otus\\Mvc\\Controllers\\' => 21,
            'Otus\\Mvc\\Assets\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Otus\\Mvc\\Views\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Views',
        ),
        'Otus\\Mvc\\Services\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Services',
        ),
        'Otus\\Mvc\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Models',
        ),
        'Otus\\Mvc\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Core',
        ),
        'Otus\\Mvc\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Controllers',
        ),
        'Otus\\Mvc\\Assets\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Assets',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1bd1a9d61171e620984c21c81252050f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1bd1a9d61171e620984c21c81252050f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1bd1a9d61171e620984c21c81252050f::$classMap;

        }, null, ClassLoader::class);
    }
}
