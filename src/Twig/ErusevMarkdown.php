<?php

namespace App\Twig;

use Twig\Extra\Markdown\MarkdownInterface;

class ErusevMarkdown implements MarkdownInterface
{
    private readonly \ParsedownExtra $converter;

    public function __construct()
    {
        $this->converter = new \ParsedownExtra();
    }

    public function convert(string $body): string
    {
        return $this->converter->text($body);
    }
}
