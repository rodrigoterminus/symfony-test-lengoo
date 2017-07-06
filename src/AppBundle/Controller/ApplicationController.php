<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Form\ApplicationType;
use AppBundle\Util\FileUploader;
use AppBundle\Util\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApplicationController
 * @package AppBundle\Controller
 */
class ApplicationController extends Controller
{
    /**
     * @Route("/", name="application_index")
     */
    public function indexAction(Request $request)
    {
        $application = new Application();
        $errors = null;
        $form = $this->createForm(ApplicationType::class, $application);

        $form->add('submit',SubmitType::class, ['label' => 'Apply']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Move uploaded file to /uploads directory
            $fileName = $this->uploadFile($application->getFile());
            $application->setFile($fileName);

            // Persist entity
            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            $this->addFlash(
                'success',
                'Thank you for applying! We will get back to you as fast as we can.'
            );

            // Send confirmation email to applicant
            $this->sendEmail($application);

            // Redirect user to the form
            return $this->redirectToRoute('application_index');
        } else if ($form->isSubmitted()) {
            $validator = $this->get('validator');
            $errors = $validator->validate($application);
        }

        return $this->render('application/index.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors,
        ));
    }

    /**
     * Upload file
     *
     * @param File $file
     * @return string
     */
    private function uploadFile(File $file) :string
    {
        $fileUploader = (new FileUploader(
                $file,
                $this->getParameter('uploads_directory')
            ))
            ->upload();

        return $fileUploader->getFileName();
    }

    /**
     * Send confirmation email
     *
     * @param Application $application
     * @return bool
     */
    private function sendEmail(Application $application) :bool
    {
        $mailer = new Mailer([
            'mailer' => $this->get('mailer'),
            'subject' => 'We received your application',
            'to' => $application->getEmail(),
            'body' => $this->renderView(
                'emails/application.html.twig',
                [ 'application' => $application ],
                'text/html'
            )
        ]);
        $mailer->send();

        return true;
    }
}
