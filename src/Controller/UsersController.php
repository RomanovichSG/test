<?php

namespace App\Controller;

use App\Service\User\Messenger\RecordUserMessage;
use App\Service\User\UserDenormalizer;
use App\Service\User\UserService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * UsersController constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(
        RequestStack $requestStack,
        LoggerInterface $logger
    ) {
        $this->requestStack = $requestStack;
        $this->logger = $logger;
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

            if (!empty($users)) {
                $firstId = $users[array_key_first($users)]['id'];
                $lastId = $users[array_key_last($users)]['id'];
                $headers = ['Content-Range' => "$firstId-$lastId"];
            }

            return $this->json(
                $users,
                Response::HTTP_OK,
                $headers ?? []
            );
        } catch (\Throwable $exception) {
            $this->logger->warning(
                $exception->getMessage(),
                [
                    $exception->getFile(),
                    $exception->getLine()
                ]
            );

            return $this->json(
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @Route("/users", methods={"POST"}, name="addUser")
     *
     * @return JsonResponse
     */
    public function addUser(
        MessageBusInterface $messageBus,
        UserDenormalizer $denormalizer
    ): JsonResponse
    {
        try {
            $content = $this->requestStack->getCurrentRequest()->getContent();

            try {
                /* @var \App\Service\User\User $content */
                $content = $denormalizer->denormalize(\json_decode($content, true));
            } catch (\InvalidArgumentException $exception) {
                return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
            }

            $messageBus->dispatch(new RecordUserMessage($content));
        } catch (\Throwable $exception) {
            $this->logger->warning(
                $exception->getMessage(),
                [
                    $exception->getFile(),
                    $exception->getLine()
                ]
            );

            return $this->json(
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json(
            Response::$statusTexts[Response::HTTP_OK],
            Response::HTTP_OK
        );
    }
}
