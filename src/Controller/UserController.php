<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_list")
     */
    public function userList(EntityManagerInterface $entityManager): Response
    {
        $customerId = $this->getUser()->getCustomer()->getId();

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['customer' => $customerId]);

        return $this->json($users);
    }
}
