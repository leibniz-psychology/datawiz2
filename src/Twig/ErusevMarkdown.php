<?php

namespace App\Twig;

use Twig\Extra\Markdown\MarkdownInterface;

readonly class ErusevMarkdown implements MarkdownInterface
{
    private \ParsedownExtra $converter;

    public function __construct()
    {
        $this->converter = new \ParsedownExtra();
    }

    public function convert(string $body): string
    {
        return $this->converter->text($body);
    }
}
