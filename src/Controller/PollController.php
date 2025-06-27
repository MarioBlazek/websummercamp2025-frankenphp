<?php

namespace App\Controller;

use App\Repository\PollRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PollController extends AbstractController
{
    #[Route('/polls', name: 'polls_index', methods: ['GET'])]
    public function __invoke(PollRepository $pollRepo): Response
    {
        $polls = $pollRepo->findAll();

        return $this->render('poll/index.html.twig', [
            'polls' => $polls,
        ]);
    }
}
