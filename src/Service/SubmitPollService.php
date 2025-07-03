<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\PollAnswersDTO;
use App\Message\PollAnswersMessage;
use App\Repository\PollOptionRepository;
use App\Repository\PollRepository;
use Symfony\Component\Messenger\MessageBusInterface;

final class SubmitPollService
{
    public function __construct(
        private PollRepository $pollRepository,
        private PollOptionRepository $pollOptionRepository,
        private MessageBusInterface $bus,
    ) {
    }

    public function __invoke(PollAnswersDTO $dto): void
    {
        $polls = $this->pollRepository->findAll();
        $pollCount = count($polls);

        if (count($dto->optionIds) !== $pollCount) {
            throw new \LogicException('You must answer all polls.');
        }

        $options = $this->pollOptionRepository->findBy(['id' => $dto->optionIds]);

        if (count($options) !== $pollCount) {
            throw new \LogicException('Some selected options are invalid.');
        }

        dump    ($dto);
        $this->bus->dispatch(new PollAnswersMessage($dto));
    }
}
