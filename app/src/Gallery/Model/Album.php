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

namespace Gallery\Model;


class Album
{
    public $albumImages;
    private $sourceDirectory;
    public $albumDirectory;

    public function __construct(string $sourceDirectory)
    {
        $this->sourceDirectory = $sourceDirectory;
    }

    private function getFullDirectory()
    {
        return $this->sourceDirectory . $this->albumDirectory;
    }

    public function loadDirectoryContent($albumDirectory)
    {
        $this->albumDirectory = $albumDirectory;
        if (!is_dir($this->getFullDirectory()))
        {
            throw new \Exception('Source directory not found');
        }

        $this->albumImages = array_diff(scandir ($this->getFullDirectory(), SCANDIR_SORT_DESCENDING), array('.', '..'));
    }

    public function toArray()
    {
        return array('name' => utf8_encode($this->albumDirectory),
                     'count' => count($this->albumImages),
                     'images' => $this->albumImages);
    }
}