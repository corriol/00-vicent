<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb743c6b3e1e1f1d6f764b592b2246296
{
    public static $files = array (
        '4aafa8e9e34eb2c31fc5ea2dac140c9d' => __DIR__ . '/../..' . '/inc/functions.php',
    );

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
            $loader->prefixLengthsPsr4 = ComposerStaticInitb743c6b3e1e1f1d6f764b592b2246296::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb743c6b3e1e1f1d6f764b592b2246296::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb743c6b3e1e1f1d6f764b592b2246296::$classMap;

        }, null, ClassLoader::class);
    }
}
