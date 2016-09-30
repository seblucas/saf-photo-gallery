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


use Gallery\Service\ShortUniqueIdService;
use Gallery\Service\WorkDirectoryService;

class Album
{
    public $albumImages;
    public $albumImagesDetail;
    public $albumDirectory;

    private $sourceDirectory;
    /** @var WorkDirectoryService  */
    private $workDirectory;

    public function __construct(string $sourceDirectory, WorkDirectoryService $workDirectory)
    {
        $this->sourceDirectory = $sourceDirectory;
        $this->workDirectory = $workDirectory;
    }

    public function getFullDirectory()
    {
        return $this->sourceDirectory . $this->albumDirectory;
    }

    public function loadDirectoryContent($albumDirectory, $withOrientation = true)
    {
        $this->albumDirectory = $albumDirectory;
        if (!is_dir($this->getFullDirectory()))
        {
            throw new \Exception('Source directory not found');
        }

        $this->albumImages = array_diff(scandir ($this->getFullDirectory(), SCANDIR_SORT_DESCENDING), array('.', '..'));

        if ($withOrientation) {
            $albumId = $this->workDirectory->getAlbumID($this->albumDirectory);
            $this->albumImagesDetail = array();
            foreach ($this->albumImages as $image) {
                $thumbnailPath = $this->workDirectory->getThumbnailPath($albumId, $image, 'small');
                $size = getimagesize ($thumbnailPath);
                if ($size[0] > $size[1]) {
                    $this->albumImagesDetail[] = array('name' => $image, 'orientation' => 'l'); // landscape
                } else {
                    $this->albumImagesDetail[] = array('name' => $image, 'orientation' => 'p'); // portrait
                }
            }
        }
    }

    public function loadFromId($id)
    {
        $this->loadDirectoryContent($this->workDirectory->getAlbumName($id));
    }

    public function toArray()
    {
        return array('name' => utf8_encode($this->albumDirectory),
                     'id' => $this->workDirectory->getAlbumID($this->albumDirectory),
                     'count' => count($this->albumImages),
                     'images' => $this->albumImages,
                     'imagesDetail' => $this->albumImagesDetail);
    }
}