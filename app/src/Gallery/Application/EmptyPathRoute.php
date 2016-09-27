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

namespace Gallery\Application;

use Silex\Route as BaseRoute;

class EmptyPathRoute extends BaseRoute
{
    private $pathIsEmpty = false;

    public function getPath()
    {
        if (!$this->pathIsEmpty) {
            return parent::getPath();
        }

        return '';
    }

    public function setPath($path)
    {
        $this->pathIsEmpty = $path === '';

        return parent::setPath($path);
    }

    public function serialize()
    {
        $data = unserialize(parent::serialize());
        $data['path_is_empty'] = $this->pathIsEmpty;

        return serialize($data);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->pathIsEmpty = $data['path_is_empty'];

        parent::unserialize($serialized);
    }
}