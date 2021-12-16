<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationFormType;
use App\Service\ApplicationFormMailer;
use App\Service\FileUploader;
use App\Service\RedisCacheService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class FormController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private ApplicationFormMailer $mailer,
        private FileUploader $fileUploader,
        private RouterInterface $router,
        private RedisCacheService $cache
    )
    {
    }

    #[Route('/wygraj-wyjazd', name: 'app_form')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ApplicationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                /** @var Application $formData */
                $formData = $form->getData();

                try {
                    $imgReceiptFileName = $this->fileUploader->upload($form->get('img_receipt')->getData());
                } catch (Exception) {
                    return new JsonResponse(['success' => false, 'errors' => ['img_receipt' => 'Wystąpił błąd podczas zapisu pliku.']]);
                }

                $shop = $formData->getShop();
                $category = $formData->getCategory();
                $where = $formData->getFromWhere();

                $application = new Application();
                $application->setFirstname($formData->getFirstname());
                $application->setLastname($formData->getLastname());
                $application->setEmail($formData->getEmail());
                $application->setParagon($formData->getParagon());
                $application->setProduct($formData->getProduct());
                $application->setPhone($formData->getPhone());
                $application->setShop($shop);
                $application->setCategory($category);
                $application->setFromWhere($where);

                $application->setBirth($formData->getBirth());
                $application->setImgReceipt($imgReceiptFileName);

                $application->setLegalA($formData->isLegalA());
                $application->setLegalB($formData->isLegalB());
                $application->setLegalC($formData->isLegalC());
                $application->setLegalD($formData->isLegalD());

                $this->manager->persist($application);
                $this->manager->flush();

                $this->mailer->sendEmail($formData);

                $url = $this->router->generate('app_thx');

                return new JsonResponse(['success' => true, 'redirect' => $url]);
            } else {
                $errors = [];

                foreach ($form->getErrors(true) as $error) {
                    $field = $error->getOrigin()->getName();
                    $errors[$field] = $error->getMessage();
                }

                return new JsonResponse(['success' => false, 'errors' => $errors]);
            }
        }
        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
            'form' => $form->createView()
        ]);
    }
}
