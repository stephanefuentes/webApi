<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManagerInterface;

class ResteService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function monnaie($nb)
    {
        if ($nb < 0)
            return -1;

        $ten = floor($nb / 10);

        $reste = $nb % 10;

        if ($reste % 2 != 0) {
            $five = floor($reste / 5);
            $reste = $reste % 5;
        }

        $two = floor($reste / 2);

        $reste = $reste % 2;

        if ($reste != 0)
            return -1;

        return [$ten, $five, $two];
    }
}
