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


use Gallery\Model\Album;

class ThumbnailService
{
    private $sourceDirectory;
    /** @var WorkDirectoryService  */
    private $workDirectory;

    public function __construct(string $sourceDirectory, WorkDirectoryService $workDirectory)
    {
        $this->sourceDirectory = $sourceDirectory;
        $this->workDirectory = $workDirectory;
    }

    public function generateThumbnail ($source, $width, $height, $outputFile) {
        if (is_null ($width) && is_null ($height)) {
            return false;
        }

        //draw the image
        $src_img = imagecreatefromjpeg($source);


        $deg = 0;

        // Do we have the ability to rotate?
        if (function_exists('exif_read_data')) {

            // Does the image have rotation set?
            $exif = exif_read_data($source);
            if($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];

                // Does it actually need rotation
                if($orientation != 1){

                    // Work out the actual rotation

                    switch ($orientation) {
                        case 3:
                            $deg = 180;
                            break;
                        case 6:
                            $deg = 270;
                            break;
                        case 8:
                            $deg = 90;
                            break;
                    }

                    // Rotate it!  (Do nothing for 0 degrees case!)

                    if ($deg) {
                        $src_img = imagerotate($src_img, $deg, 0);
                    }
                }
            }
        }


        // get image size
        if ($size = getimagesize ($source)) {
            if ($deg == 90 || $deg == 270) {
                $h = $size[0];
                $w = $size[1];
            } else {
                $w = $size[0];
                $h = $size[1];
            }
            //set new size
            if (!is_null ($width)) {
                $nw = $width;
                if ($nw >= $w) {
                    return false;
                }
                $nh = ($nw*$h)/$w;
            } else {
                $nh = $height;
                if ($nh >= $h) {
                    return false;
                }
                $nw = ($nh*$w)/$h;
            }
        } else {
            return false;
        }

        $dst_img = imagecreatetruecolor($nw,$nh);
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $nw, $nh, $w, $h);//resizing the image
        imagejpeg($dst_img,$outputFile,80);
        imagedestroy($src_img);
        imagedestroy($dst_img);

        return true;
    }


    public function getThumbnailPath($albumId, Album $album, $imageName, $size)
    {
        $realImagePath = $album->getFullDirectory() . '/' . $imageName;
        $thumbnailPath = $this->workDirectory->getThumbnailPath($albumId, $imageName, $size);

        if (!is_readable($thumbnailPath)) {
            $this->generateThumbnail($realImagePath, null, 328, $thumbnailPath);
        }
        return $thumbnailPath;
    }
}