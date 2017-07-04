<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $applications = $em->getRepository('AppBundle:Application')->findAll();

        return $this->render('admin/index.html.twig', [
            'applications' => $applications,
        ]);
    }

}
