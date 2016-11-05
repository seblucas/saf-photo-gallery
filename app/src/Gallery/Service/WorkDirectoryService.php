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

namespace Gallery\Service;


class WorkDirectoryService
{
    private $sourceDirectory;
    private $workDirectory;
    /** @var  ShortUniqueIdService */
    private $shortId;

    private $REAL_DIRECTORY_NAME = '/.real';

    public function __construct($sourceDirectory, $workDirectory, ShortUniqueIdService $shortId)
    {
        $this->sourceDirectory = $sourceDirectory;
        $this->workDirectory = $workDirectory;
        $this->shortId = $shortId;
    }

    public function getAlbumID($albumName)
    {
        $id = $this->shortId->generate($albumName);
        $albumDirectory = $this->workDirectory . $id;
        if (!is_dir($albumDirectory)) {
            mkdir($albumDirectory);
            file_put_contents($albumDirectory . $this->REAL_DIRECTORY_NAME, $albumName);
        }
        return $id;
    }

    public function getAlbumName($id)
    {
        $albumDirectory = $this->workDirectory . $id;
        if (!is_readable($albumDirectory . $this->REAL_DIRECTORY_NAME)) {
            throw new \Exception("Album hash not found");
        }
        return file_get_contents($albumDirectory . $this->REAL_DIRECTORY_NAME);
    }

    public function getThumbnailPath($albumId, $imageName, $size)
    {
        $directory = $this->workDirectory . $albumId . '/' . $size;
        if (!is_dir($directory)) {
            mkdir($directory);
        }

        return $directory . '/' . $imageName;
    }

}