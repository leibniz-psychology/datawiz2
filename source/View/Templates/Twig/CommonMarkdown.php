<?php

namespace App\View\Templates\Twig;

// use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use Twig\Extra\Markdown\MarkdownInterface;

class CommonMarkdown implements MarkdownInterface
{
    // Define your configuration, if needed
    private $config = [];
    private $environment;
    private $converter;

    public function __construct(MarkdownConverter $converter = null)
    {
        // Configure the Environment with all the CommonMark parsers/renderers
        $this->environment = new Environment($this->config);
        $this->environment->addExtension(new CommonMarkCoreExtension());
        $this->environment->addExtension(new AttributesExtension());
        $this->converter = $converter ?: new MarkdownConverter($this->environment);
    }

    public function convert(string $body): string
    {
        return $this->converter->convertToHtml($body);
    }
}
