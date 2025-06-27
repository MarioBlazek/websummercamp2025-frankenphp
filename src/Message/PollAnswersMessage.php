<?php

namespace App\Message;

use App\DTO\PollAnswersDTO;

readonly class PollAnswersMessage
{
    public function __construct(
        public PollAnswersDTO $dto,
    ) {
    }
}
