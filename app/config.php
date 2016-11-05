<?php
/**
 * This file is part of SAF Photo Gallery
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @copyright  Copyright(c) 2016 Sébastien Lucas
 * @author     Sébastien Lucas <sebastien@slucas.fr>
 */

// Config that gets passed into main Silex/App instance
return array(
    'env' => 'development',
    'debug' => true,
    'template.config' => array(
        'path' => SILEX_APP_ROOT . 'template/default',
        'cache' => false, //SILEX_ROOT . 'cache/twig',
        'debug' => false
    ),
    'gallery.config' => array(
        'version' => '0.0.1',
        // Please always add a trailing slash
        'source' => 'c:/Partage/Photo/',
        'work' => 'c:/Partage/bfdir/'
    )
);