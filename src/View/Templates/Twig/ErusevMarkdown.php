<?php

namespace App\View\Templates\Twig;

use ParsedownExtra;
use Twig\Extra\Markdown\MarkdownInterface;

class ErusevMarkdown implements MarkdownInterface
{
    private readonly ParsedownExtra $converter;

    public function __construct()
    {
        $this->converter = new ParsedownExtra();
    }

    public function convert(string $body): string
    {
        return $this->converter->text($body);
    }
}
