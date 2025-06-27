<?php

namespace App\Controller;

use App\DTO\PollAnswersDTO;
use App\Service\SubmitPollService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PollAnswerController extends AbstractController
{
    public function __construct(
        private SubmitPollService $submitPollService,
    ) {
    }

    #[Route('/poll/answer', name: 'poll_answer', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] PollAnswersDTO $dto,
        ValidatorInterface $validator,
    ): Response {
        $errors = $validator->validate($dto);

        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        try {
            ($this->submitPollService)($dto);
        } catch (\Exception $exception) {
            return $this->json(['errors' => (string) $exception->getMessage()], 400);
        }

        return new JsonResponse(['status' => 'Answers submitted'], 202);
    }
}
