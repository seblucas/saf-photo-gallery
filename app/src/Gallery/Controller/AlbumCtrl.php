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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlbumCtrl
{
    /** @var  \Twig_Environment */
    private $twig;
    /** @var  Album */
    private $album;


    public function __construct(\Twig_Environment $twig, Album $album)
    {
        $this->twig = $twig;
        $this->album = $album;
    }

    public function getOneAlbum(Request $request)
    {
        $albumName = utf8_decode($request->get('a'));
        $this->album->loadDirectoryContent($albumName);
        return new Response($this->twig->render('album-detail.html.twig', array('album' => $this->album->toArray())),
            200);
    }
}