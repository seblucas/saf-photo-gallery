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

class AlbumFactory
{
    private $sourceDirectory;
    private $shortId;

    public function __construct(string $sourceDirectory, ShortUniqueIdService $shortId)
    {
        $this->sourceDirectory = $sourceDirectory;
        $this->shortId = $shortId;
    }

    public function getAlbum()
    {
        return new Album($this->sourceDirectory, $this->shortId);
    }

}