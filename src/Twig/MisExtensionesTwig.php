<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MisExtensionesTwig extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('now', [$this, 'getCurrentDateTime']),
        ];
    }

    public function getCurrentDateTime()
    {
        return new \DateTime();
    }
}
