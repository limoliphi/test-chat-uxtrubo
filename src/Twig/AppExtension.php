<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('pluralize', [$this, 'pluralize']),
        ];
    }

    public function pluralize(int $count, string $singular, ?string $plural = null): string
    {
        //Pour le pluriel : si ça existe et que ça n'est pas nul, on l'utilise
        //sinon on devine le pluriel, on va dire que c'est le singulier avec un s
        $plural = $plural ?? $singular . 's';

        //ternaire
        $str = $count === 0 ? $singular : $plural;

        return "$count $str";
    }
}
