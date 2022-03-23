<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit523155cc2cbc6f295d48d783a8c2bd20
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Ilia\\Otus\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ilia\\Otus\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit523155cc2cbc6f295d48d783a8c2bd20::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit523155cc2cbc6f295d48d783a8c2bd20::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit523155cc2cbc6f295d48d783a8c2bd20::$classMap;

        }, null, ClassLoader::class);
    }
}
