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


use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AlbumList
{
    public $albumList;
    private $sourceDirectory;

    public function __construct(string $sourceDirectory)
    {
        $this->sourceDirectory = $sourceDirectory;
        $this->loadDirectoryContent();
    }

    private function loadDirectoryContent()
    {
        if (!is_dir($this->sourceDirectory))
        {
            throw new FileNotFoundException('Source directory not found');
        }

        $this->albumList = array_diff(scandir ($this->sourceDirectory, SCANDIR_SORT_DESCENDING), array('.', '..', '@eaDir', '.sync'));
    }

    public function getAlbumPerYear()
    {
        $albumsPerYear = array();
        $precedingYear = NULL;
        foreach($this->albumList as $album)
        {
            $currentYear = substr($album, 0, 4);
            if (!array_key_exists($currentYear, $albumsPerYear))
            {
                $albumsPerYear[$currentYear] = [];
            }
            $albumsPerYear[$currentYear][] = $album;
        }
        return $albumsPerYear;
    }
}