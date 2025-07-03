<?php

namespace App\Command;

use App\Entity\Poll;
use App\Entity\PollOption;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:init-polls',
    description: 'Initialize default polls',
)]
class InitPollsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $polls = [
            [
                'question' => 'What is your favorite programming language?',
                'options' => ['PHP', 'JavaScript', 'Python', 'Go'],
            ],
            [
                'question' => 'What is the best Symfony conference?',
                'options' => ['WSC', 'WSC', 'WSC', 'WSC'],
            ],
            [
                'question' => 'What’s your go-to debugging method?',
                'options' => ['Staring at the screen', 'var_dump()', 'xdebug', 'dump() & die()'],
            ],
        ];

        foreach ($polls as $data) {
            $poll = new Poll();
            $poll->setQuestion($data['question']);

            foreach ($data['options'] as $label) {
                $option = new PollOption();
                $option->setText($label);
                $option->setVotes(0);
                $poll->addOption($option);
            }

            $this->em->persist($poll);
        }

        $this->em->flush();

        $output->writeln('<info>Polls initialized successfully!</info>');

        return Command::SUCCESS;
    }
}
