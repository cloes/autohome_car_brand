<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0fc940e827ea455de99f0e4d81b85ba7
{
    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\Dom\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\Dom\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-dom/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0fc940e827ea455de99f0e4d81b85ba7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0fc940e827ea455de99f0e4d81b85ba7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}