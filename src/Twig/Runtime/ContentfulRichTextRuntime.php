<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ContentfulRichTextRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function contentfulRichText($value)
    {
        $renderer = new \Contentful\RichText\Renderer();

        $content = $renderer->render($value);
        preg_match('/<p>(.*?)<\/p>/s', $content, $match);
        $result = strip_tags($match[0]);
        $wordCount = 30;

        $words = explode(" ", $result);
        return implode(" ", array_slice($words, 0, $wordCount));
    }
}
