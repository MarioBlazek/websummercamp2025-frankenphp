<?php

namespace App\MessageHandler;

use App\Entity\PollAnswer;
use App\Message\PollAnswersMessage;
use App\Repository\PollOptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PollAnswersMessageHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private PollOptionRepository $optionRepository,
    ) {
    }

    public function __invoke(PollAnswersMessage $message): void
    {
        $dto = $message->dto;

        $options = $dto->optionIds;
        foreach ($options as $optionId) {
            $option = $this->optionRepository->find($optionId);
            if (!$option) {
                throw new \InvalidArgumentException("Option with ID $optionId not found");
            }
            $answer = new PollAnswer();
            $answer->setPoll($option->getPoll())
                ->setOption($option)
                ->setUserName($dto->userName);

            $option->addVote();

            $this->em->persist($answer);
            $this->em->persist($option);
        }

        $this->em->flush();
    }
}
