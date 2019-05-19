<?php

namespace App\Controller;

use App\Service\User\User;
use App\Service\User\UserDenormalizer;
use App\Service\User\UserService;
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

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * UsersController constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(
        RequestStack $requestStack
    ) {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/users", methods={"GET"}, name="users")
     *
     * @return JsonResponse
     */
    public function index(UserService $userService): JsonResponse
    {
        try {
            $request = $this->requestStack->getCurrentRequest();
            $users = $userService->getUsersListing(
                $request->get('page'),
                $request->get('firstName'),
                $request->get('sorting')
            );

            return $this->json($users, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->json('Internal service error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/users", methods={"POST"}, name="addUser")
     *
     * @return JsonResponse
     */
    public function addUser(UserDenormalizer $denormalizer): JsonResponse
    {
        try {
            $content = $this->requestStack->getCurrentRequest()->getContent();
            $content = \json_decode($content, true);

            try {
                /* @var User $user */
                $user = $denormalizer->denormalize($content, User::class);
            } catch (\InvalidArgumentException $exception) {
                return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $exception) {
            return $this->json('Internal service error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
