<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
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

    /**
     * @Route("/application/{id}", name="admin_application")
     */
    public function applicationAction(Application $application) {
        return $this->render('admin/application.html.twig', [
            'application' => $application
        ]);
    }
}
