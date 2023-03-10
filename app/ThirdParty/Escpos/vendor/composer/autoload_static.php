<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1c1af9545cf28fb01b113ba1e38a649f
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mike42\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mike42\\' => 
        array (
            0 => __DIR__ . '/..' . '/mike42/gfx-php/src/Mike42',
            1 => __DIR__ . '/..' . '/mike42/escpos-php/src/Mike42',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1c1af9545cf28fb01b113ba1e38a649f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1c1af9545cf28fb01b113ba1e38a649f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1c1af9545cf28fb01b113ba1e38a649f::$classMap;

        }, null, ClassLoader::class);
    }
}
