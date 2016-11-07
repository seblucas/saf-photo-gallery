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

namespace Gallery\Controller;


use Gallery\Model\Album;
use Gallery\Service\ThumbnailService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ThumbnailCtrl
{
    /** @var  Album */
    private $album;
    /** @var  ThumbnailService */
    private $thumbnailService;
    private $xAccelRedirect;


    public function __construct(Album $album, ThumbnailService $thumbnailService, $xAccelRedirect)
    {
        $this->album = $album;
        $this->thumbnailService = $thumbnailService;
        $this->xAccelRedirect = $xAccelRedirect;
    }

    public function getOneThumbnail(Request $request, $albumId)
    {
        $thumbnailPath = $this->getThumbnailPath($request, $albumId);
        if (!$this->xAccelRedirect) {
            $response = new BinaryFileResponse($thumbnailPath);
        } else {
            $imageName = $request->get('i'); // TODO Protect the call with a regexp to avoid path injection
            $size = $request->get('s');
            $response = new Response('', 200, array(
                'X-Accel-Redirect' => $this->xAccelRedirect . $albumId . '/' . $size . '/' . $imageName,
                'Content-Type' => image/jpeg));
        }
        $response->setMaxAge(60 * 60 * 24 * 90); // 90 days
        return $response;
    }

    public function generateOneThumbnail(Request $request, $albumId)
    {
        $this->getThumbnailPath($request, $albumId);
        return "OK";
    }

    /**
     * @param Request $request
     * @param $albumId
     * @return string
     */
    private function getThumbnailPath(Request $request, $albumId)
    {
        $imageName = $request->get('i'); // TODO Protect the call with a regexp to avoid path injection
        $size = $request->get('s');
        $this->album->loadFromId($albumId);
        $thumbnailPath = $this->thumbnailService->getThumbnailPath($albumId, $this->album, $imageName, $size);
        return $thumbnailPath;
    }
}