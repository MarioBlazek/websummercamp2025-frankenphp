<?php

namespace App\Controller;

use App\Repository\PollRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PollResultsController extends AbstractController
{
    #[Route('/poll/results', name: 'poll_results', methods: ['GET'])]
    public function __invoke(PollRepository $pollRepo): Response
    {
        $polls = $pollRepo->findAll();

        return $this->render('poll/results.html.twig', [
            'polls' => $polls,
        ]);
    }
}
