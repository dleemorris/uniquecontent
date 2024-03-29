<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0463ce1053a77957c38575969e98023d
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'EA\\Licensing\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'EA\\Licensing\\' => 
        array (
            0 => __DIR__ . '/..' . '/easily-amused/php-packages/Licensing',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0463ce1053a77957c38575969e98023d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0463ce1053a77957c38575969e98023d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0463ce1053a77957c38575969e98023d::$classMap;

        }, null, ClassLoader::class);
    }
}
