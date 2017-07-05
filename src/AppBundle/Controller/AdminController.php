<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\File\File;

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

    /**
     * @Route("/download_application_file/{id}", name="admin_application_file_download")
     */
    public function applicationFileDownloadAction(Application $application) {
        $file = new File($this->getParameter('uploads_directory').'/'.$application->getFile());

        $response = new BinaryFileResponse($file);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }
}
