<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1d574d590064c05ca50cf3b318078ba5
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Keemia\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Keemia\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/class',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1d574d590064c05ca50cf3b318078ba5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1d574d590064c05ca50cf3b318078ba5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1d574d590064c05ca50cf3b318078ba5::$classMap;

        }, null, ClassLoader::class);
    }
}
