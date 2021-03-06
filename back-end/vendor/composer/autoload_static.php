<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaa4d1572866d8a0cad22f27f574e0f92
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaa4d1572866d8a0cad22f27f574e0f92::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaa4d1572866d8a0cad22f27f574e0f92::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaa4d1572866d8a0cad22f27f574e0f92::$classMap;

        }, null, ClassLoader::class);
    }
}
