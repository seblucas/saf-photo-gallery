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

define('SILEX_ROOT', dirname(__FILE__) . '/../');
define('SILEX_APP_ROOT', SILEX_ROOT . '/app/');
define('SILEX_SRC_ROOT', SILEX_APP_ROOT . '/src/');

// Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Silex App
$app = new \Gallery\Application\Application(require SILEX_APP_ROOT . 'config.php');

$app->run();