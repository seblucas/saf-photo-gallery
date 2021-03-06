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

namespace Gallery\Model;


use Gallery\Service\AlbumFactory;

class AlbumList
{
    public $albumList;
    private $sourceDirectory;
    private $albumFactory;

    public function __construct($sourceDirectory, AlbumFactory $albumFactory)
    {
        $this->sourceDirectory = $sourceDirectory;
        $this->albumFactory = $albumFactory;
        $this->loadDirectoryContent();
    }

    private function loadDirectoryContent()
    {
        if (!is_dir($this->sourceDirectory))
        {
            throw new \Exception('Source directory not found');
        }

        $this->albumList = array_diff(scandir ($this->sourceDirectory, SCANDIR_SORT_DESCENDING), array('.', '..', '@eaDir', '.sync'));
    }

    public function toArray()
    {
        $albumsPerYear = array();
        $precedingYear = NULL;
        foreach($this->albumList as $album)
        {
            $currentAlbum = $this->albumFactory->getAlbum();
            $currentAlbum->loadDirectoryContent($album);

            $currentYear = substr($album, 0, 4);
            if (!array_key_exists($currentYear, $albumsPerYear))
            {
                $albumsPerYear[$currentYear] = [];
            }
            $albumsPerYear[$currentYear][] = $currentAlbum->toArray();
        }
        return $albumsPerYear;
    }
}