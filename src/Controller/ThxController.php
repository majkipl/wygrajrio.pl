<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThxController extends AbstractController
{
    #[Route('/podziekowania', name: 'app_thx')]
    public function index(): Response
    {
        return $this->render('thx/index.html.twig', [
            'controller_name' => 'ThxController',
        ]);
    }

    #[Route('/kontakt/podziekowania', name: 'app_contact_thx')]
    public function contact(): Response
    {
        return $this->render('thx/contact.html.twig', [
            'controller_name' => 'ThxController',
        ]);
    }
}
