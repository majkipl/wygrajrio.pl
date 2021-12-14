<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    #[Route('/', name: 'app_default', methods: ['GET'])]
    public function index(): Response
    {
        $form = $this->createForm(ContactFormType::class, null, [
            'action' => $this->generateUrl('app_contact')
        ]);

        $applications = $this->manager->getRepository(Application::class)->findBy([], ['id' => 'DESC'], 4);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'applications' => $applications,
            'formContact' => $form->createView()
        ]);
    }
}
