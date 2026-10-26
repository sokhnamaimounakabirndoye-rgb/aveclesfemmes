<?php

namespace App\Entity;

use App\Repository\MembreSimpleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreSimpleRepository::class)]
class MembreSimple extends Role
{
}