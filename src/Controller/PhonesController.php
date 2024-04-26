<?php

namespace App\Controller;

use App\Repository\PhoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhonesController extends AbstractController
{
    #[Route('/phones', name: 'app_phones')]
    public function index(PhoneRepository $phoneRepository,RequestStack $requestStack): Response
    {
        $currentRequest = $requestStack->getCurrentRequest();
        $currentUrl = $currentRequest->getPathInfo();

        $phones = $phoneRepository->findAll();

        return $this->render('phones/index.html.twig', [
            'currentUrl' => $currentUrl,
            'phones' => $phones,
        ]);
    }
}
