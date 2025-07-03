<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FrankenPHPController extends AbstractController
{
    #[Route('/franken/debug', name: 'franken_debug')]
    public function __invoke(Request $request): JsonResponse
    {
        $frankenInfo = [];

        // Check if FrankenPHP is running
        $frankenInfo['is_frankenphp'] = isset($_SERVER['FRANKENPHP']);

        // Worker process mode
        $frankenInfo['is_worker_mode'] = $_SERVER['FRANKENPHP_WORKER'] ?? false;

        // Current process PID (to check if worker is reused)
        $frankenInfo['php_pid'] = getmypid();

        // Optional: get script name or headers
        $frankenInfo['script'] = $_SERVER['SCRIPT_FILENAME'] ?? null;
        $frankenInfo['request_uri'] = $_SERVER['REQUEST_URI'] ?? null;

        // You can add cache or timestamp to track reuse
        static $hitCount = 0;
        $hitCount++;
        $frankenInfo['hit_count_in_this_process'] = $hitCount;

        return new JsonResponse($frankenInfo);
    }
}
