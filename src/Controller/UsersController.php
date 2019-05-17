<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UsersController
 *
 * @package App\Controller
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="users")
     */
    public function index()
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
}
