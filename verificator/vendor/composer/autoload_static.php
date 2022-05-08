<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7672cdbadd6a1b3331cd8ebd850c7111
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit7672cdbadd6a1b3331cd8ebd850c7111::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7672cdbadd6a1b3331cd8ebd850c7111::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7672cdbadd6a1b3331cd8ebd850c7111::$classMap;

        }, null, ClassLoader::class);
    }
}
