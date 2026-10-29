<?php

namespace App\Entity;

use App\Repository\EpargneDureePreciseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpargneDureePreciseRepository::class)]
class EpargneDureePrecise extends Epargne
{
}