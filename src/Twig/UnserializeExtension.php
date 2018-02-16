<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UnserializeExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('unserialize', array($this, 'unserialize')),
        );
    }

    public function unserialize($string)
    {
        return unserialize($string);
    }
}