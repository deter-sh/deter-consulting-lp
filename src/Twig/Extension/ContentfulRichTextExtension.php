<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\ContentfulRichTextRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ContentfulRichTextExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('contentfulRichText', [ContentfulRichTextRuntime::class, 'contentfulRichText']),
        ];
    }
}
