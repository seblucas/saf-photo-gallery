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

namespace Gallery\Application;

use Gallery\Provider\Models;
use Gallery\Provider\Services;
use Gallery\Provider\Controllers;
use Silex;
use Silex\Application as SilexApplication;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application extends SilexApplication
{
    function __construct(array $baseConfig)
    {
        parent::__construct($baseConfig);
        $this['debug'] = true;
        //$this['route_class'] = EmptyPathRoute::class;
        $this->registerProviders();
        $this->registerViewHandlers();
        $this->registerExceptionHandlers();
        $this->mountControllers();
    }

    private function registerProviders()
    {
        $this->register(new Silex\Provider\ServiceControllerServiceProvider());
        $this->register(new Silex\Provider\AssetServiceProvider(), array(
            'assets.version' => 'v1',
            'assets.version_format' => '%s?v=%s',
            'assets.named_packages' => array(
                'images' => array('version' => 'v1', 'base_path' => '/images'),
            ),
        ));
        $this->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => $this['template.config']['path'],
            'twig.options' => array(
                'cache' => $this['template.config']['cache'],
                'debug' => $this['template.config']['debug'],
                'strict_variables' => false
            )
        ));
        $this->register(new Services());
        $this->register(new Models());
        $this->register(new Controllers());
    }

    private function registerViewHandlers()
    {
    }

    private function registerExceptionHandlers()
    {
    }

    private function mountControllers()
    {
        $this->get('/', 'controller.AlbumList:getAllAlbums');
        $this->get('/album/', 'controller.Album:getOneAlbum')
            ->bind('album.detail');
        $this->get('/album/{albumId}/thumbnail', 'controller.Thumbnail:getOneThumbnail')
            ->bind('thumbnail');
    }

}
