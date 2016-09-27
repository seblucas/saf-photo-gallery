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

namespace Gallery\Provider;

use Gallery\Service\AlbumFactory;
use Gallery\Service\ShortUniqueIdService;
use Pimple\Container;

class Services extends Base {
    public function register(Container $app) {
        $app['service.ShortId'] = function($app) {
            return new ShortUniqueIdService();
        };

        $app['factory.Album'] = function($app) {
            return new AlbumFactory($app['gallery.config']['source'], $app['service.ShortId']);
        };
    }
}