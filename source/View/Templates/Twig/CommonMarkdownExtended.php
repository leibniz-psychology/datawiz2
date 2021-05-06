<?php

namespace App\View\Templates\Twig;

use League\CommonMark\CommonMarkConverter;
use Twig\Extra\Markdown\MarkdownInterface;

class CommonMarkdownExtended implements MarkdownInterface
{
    private $converter;

    public function __construct(CommonMarkConverter $converter = null)
    {
        $this->converter = $converter ?: new CommonMarkConverter();
    }

    public function convert(string $body): string
    {
        return $this->converter->convertToHtml($body);
    }
}
