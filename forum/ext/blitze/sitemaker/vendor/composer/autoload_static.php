<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2f580e2826414c7966db9f9b2ed47ace
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Urodoz\\Truncate\\' => 16,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Urodoz\\Truncate\\' => 
        array (
            0 => __DIR__ . '/..' . '/urodoz/truncate-html/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'SimplePie' => 
            array (
                0 => __DIR__ . '/..' . '/simplepie/simplepie/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2f580e2826414c7966db9f9b2ed47ace::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2f580e2826414c7966db9f9b2ed47ace::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit2f580e2826414c7966db9f9b2ed47ace::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
