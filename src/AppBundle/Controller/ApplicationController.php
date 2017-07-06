<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Form\ApplicationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $form = $this->createForm(ApplicationType::class, $application);

        $form->add('submit',SubmitType::class, ['label' => 'Apply']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $application->getFile();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('uploads_directory'),
                $fileName
            );

            $application
                ->setFile($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            $this->addFlash('success', 'Thank you for applying! We will get back to you as fast as we can.');

            // Send success email to applicant
            $message = (new \Swift_Message('We received your application'))
                ->setFrom('contact@lengoo.com')
                ->setTo($application->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/application.html.twig',
                        [
                            'application' => $application
                        ]
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('application_index');
        }

        return $this->render('application/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
