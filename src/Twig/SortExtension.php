<?php

namespace App\Twig;

use Twig\Error\RuntimeError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SortExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('custsort', [$this, 'sort']),
        ];
    }

    /**
     * @param $array
     * @param null $arrow
     *
     * @return array
     *
     * @throws RuntimeError
     */
    public function sort($array, $arrow = null)
    {
        if ($array instanceof \Traversable) {
            $array = iterator_to_array($array);
        } elseif (!\is_array($array)) {
            throw new RuntimeError(sprintf('The sort filter only works with arrays or "Traversable", got "%s".', \gettype($array)));
        }

        if (null !== $arrow) {
            usort($array, $arrow);
        } else {
            sort($array);
        }

        return $array;
    }
}
