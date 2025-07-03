<?php

namespace App\MessageHandler;

use App\Entity\PollAnswer;
use App\Message\PollAnswersMessage;
use App\Repository\PollOptionRepository;
use App\Service\MercureJwtProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mercure\Update;

#[AsMessageHandler]
class PollAnswersMessageHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private PollOptionRepository $optionRepository,
        private HubInterface $publisher,
    ) {
    }

    public function __invoke(PollAnswersMessage $message): void
    {
        $dto = $message->dto;

        $options = $dto->optionIds;
        $polls = [];
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
            $polls[] = $option->getPoll();

            $this->em->persist($answer);
            $this->em->persist($option);
        }

        $this->em->flush();

        if (!$polls) {
            return; // no updates to publish
        }

        $data = [];
        foreach ($polls as $poll) {
            $votes = [];
            foreach ($poll->getOptions() as $option) {
                $votes[$option->getId()] = $option->getVotes();
            }
            $data[$poll->getId()] = $votes;
        }

        $update = new Update(
            topics: 'poll-results',
            data: json_encode($data),
            private: false,
        );

        try {
            $this->publisher->publish($update);
        } catch (\Throwable $exception) {
            dd($exception);
        }
    }
}
