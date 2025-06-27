<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PollAnswersDTO
{
    #[Assert\NotBlank]
    public string $userName;

    /**
     * @var int[]
     */
    #[Assert\NotBlank]
    #[Assert\All([
        new Assert\NotNull(),
        new Assert\Type('int'),
    ])]
    public array $optionIds = [];
}
