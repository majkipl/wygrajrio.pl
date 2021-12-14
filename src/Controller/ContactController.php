<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Service\ContactFormMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ContactController extends AbstractController
{

    public function __construct(private ContactFormMailer $mailer, private RouterInterface $router)
    {
    }

    #[Route('/kontakt', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactFormType::class, null, [
            'action' => $this->generateUrl('app_contact')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $formData = $form->getData();

                $this->mailer->sendContactEmail($formData);

                $url = $this->router->generate('app_contact_thx');

                return new JsonResponse(['success' => true, 'redirect' => $url]);
            } else {
                $errors = [];
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }

                return new JsonResponse(['success' => false, 'errors' => $errors]);
            }
        }

        return new JsonResponse(['success' => false, 'errors' => '404 Not Found']);
    }
}
