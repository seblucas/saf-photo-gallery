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


use Gallery\Model\AlbumList;
use Symfony\Component\HttpFoundation\Response;

class IndexCtrl
{
    /** @var  \Twig_Environment */
    private $twig;
    /** @var  AlbumList */
    private $albumList;


    public function __construct(\Twig_Environment $twig, AlbumList $albumList)
    {
        $this->twig = $twig;
        $this->albumList = $albumList;
    }

    public function getAllAlbums()
    {
        $albumPerYear = $this->albumList->toArray();
        return new Response($this->twig->render('index.html.twig', array('albumsPerYear' => $albumPerYear)),
            200);
    }

    public function adminAllAlbums()
    {
        $albumPerYear = $this->albumList->toArray();
        return new Response($this->twig->render('admin.html.twig', array('albumsPerYear' => $albumPerYear)),
            200);
    }
}