<?php
// Config that gets passed into main Silex/App instance
return array(
    'env' => 'development',
    'template.config' => array(
        'path' => SILEX_APP_ROOT . 'template/default',
        'cache' => false, //SILEX_ROOT . 'cache/twig',
        'debug' => false
    ),
    'gallery.config' => array(
        'version' => '0.0.1',
        'source' => 'c:/Partage/Photo/',
        'app' => 'c:/Partage/bfdir/'
    )
);