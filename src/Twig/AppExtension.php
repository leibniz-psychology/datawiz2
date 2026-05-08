<?php

namespace App\Twig;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Twig\Attribute\AsTwigFunction;

class AppExtension
{
    public function __construct(
        private readonly PropertyAccessorInterface $accessor
    ) {
    }

    #[AsTwigFunction('getAttribute')]
    public function getAttribute($entity, $property)
    {
        return $this->accessor->getValue($entity, $property);
    }
}
