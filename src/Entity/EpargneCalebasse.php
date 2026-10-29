<?php

namespace App\Entity;

use App\Repository\EpargneCalebasseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpargneCalebasseRepository::class)]
class EpargneCalebasse extends Epargne
{
}