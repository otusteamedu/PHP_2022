<?php

namespace App\DTO;

use App\Entity\Student;
use Symfony\Component\Validator\Constraints as Assert;

class SaveStudentDTO
{






    public function __construct(array $data)
    {



    }

    public static function fromEntity(Student $student): self
    {
        return new self([

        ]);
    }
}