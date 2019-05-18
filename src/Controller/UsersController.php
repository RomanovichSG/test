<?php

namespace App\Controller;

use App\Service\User\User;
use App\Service\User\UserDenormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UsersController
 *
 * @package App\Controller
 */
class UsersController extends AbstractController
{

    private $requestStack;

    private $denormalizer;

    /**
     * UsersController constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(
        RequestStack $requestStack,
        UserDenormalizer $denormalizer
    ) {
        $this->requestStack = $requestStack;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @Route("/", methods={"GET"}, name="users")
     */
    public function index()
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route("/", methods={"POST"}, name="addUser")
     *
     * @return JsonResponse
     */
    public function post() : JsonResponse
    {
        $content = $this->requestStack->getCurrentRequest()->getContent();
        $content = json_decode($content, true);

        try {
            /* @var User $user */
            $user = $this->denormalizer->denormalize($content, User::class);
        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
