<?php
/**
 * This file is part of BF Photo Gallery
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @copyright  Copyright(c) 2016 Sébastien Lucas
 * @author     Sébastien Lucas <sebastien@slucas.fr>
 */

namespace Gallery\Provider;

use Gallery\Model\AlbumList;
use Pimple\Container;

class Models extends Base {
    public function register(Container $app) {
        $app['model.AlbumList'] = function($app) {
            return new AlbumList($app['gallery.config']['source']);
        };
    }
}