<?php

namespace App\Controller\Panel;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager
    )
    {
        //
    }

    #[Route('/panel/zgloszenie', name: 'app_panel_application')]
    public function index(): Response
    {
        $items = $this->manager->getRepository(Application::class)->findAll();

        return $this->render('panel/application/index.html.twig', [
            'controller_name' => 'ApplicationController',
            'items' => $items
        ]);
    }

    #[Route('/panel/zgloszenie/{id}', name: 'app_panel_application_show', methods: ['GET'])]
    public function show(Application $application): Response
    {
        return $this->render('panel/application/show.html.twig', [
            'application' => $application,
        ]);
    }

    #[Route('/panel/zgloszenie/usun/{id}', name: 'app_panel_application_delete', methods: ['GET'])]
    public function delete(Application $application): RedirectResponse
    {
        $this->manager->remove($application);
        $this->manager->flush();

        return new RedirectResponse($this->generateUrl('app_panel_application'));
    }
}
