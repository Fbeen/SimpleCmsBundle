<?php

namespace Fbeen\SimpleCmsBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Admin controller.
 */
class AdminController extends Controller
{
    public function clearcacheAction()
    {
        $cacheDir = $this->get('kernel')->getRootDir() . '/../var/cache/' . $this->get('kernel')->getEnvironment();
        
        // prepare the redirect because it uses the cache
        $response = $this->redirectToRoute('sonata_admin_dashboard');
        
        // now delete the cache directory
        $fs = new Filesystem();
        $fs->remove($cacheDir);

        return $response;
    }
}
