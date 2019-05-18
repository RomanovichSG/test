<?php

namespace App\Controller;

use App\Service\User\User;
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
     * @var UserService
     */
    private $userService;

    /**
     * UsersController constructor.
     *
     * @param RequestStack $requestStack
     * @param UserService $userService
     */
    public function __construct(
        RequestStack $requestStack,
        UserService $userService
    ) {
        $this->requestStack = $requestStack;
        $this->userService = $userService;
    }

    /**
     * @Route("/users", methods={"GET"}, name="users")
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $request = $this->requestStack->getCurrentRequest();

        $page = $request->get('page');
        $page = is_numeric($page) ? (integer) $page : 1;

        $firstName = $request->get('firstName');
        $firstName = is_string($firstName) ? $firstName : '';

        $sorting = $request->get('sorting');
        $sorting = is_string($sorting) ? $sorting : '';

        $users = $this->userService->getRepository()
            ->getUsers($page, $firstName, $sorting);

        foreach ($users as &$user) {
            $phoneNumbers = $user->getUserPhoneNumbers();
            $numbers = [];
            foreach ($phoneNumbers as $number) {
                $numbers[] = $number->getPhoneNumber();
            }

            $user = [
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'phoneNumbers' => $numbers,
            ];
        }
        unset($user);

        return $this->json($users, Response::HTTP_OK);
    }

    /**
     * @Route("/users", methods={"POST"}, name="addUser")
     *
     * @return JsonResponse
     */
    public function addUser(): JsonResponse
    {
        $content = $this->requestStack->getCurrentRequest()->getContent();
        $content = \json_decode($content, true);

        try {
            /* @var User $user */
            $user = $this->userService
                ->getDenormalizer()
                ->denormalize($content, User::class);
        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
