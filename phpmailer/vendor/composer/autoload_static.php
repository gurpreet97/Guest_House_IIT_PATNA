<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit58fd7d0759380b23f979ea5534e645ce
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit58fd7d0759380b23f979ea5534e645ce::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit58fd7d0759380b23f979ea5534e645ce::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
