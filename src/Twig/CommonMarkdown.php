<?php

namespace App\Twig;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\MarkdownConverter;
use Twig\Extra\Markdown\MarkdownInterface;

class CommonMarkdown implements MarkdownInterface
{
    // Define your configuration, if needed
    private array $config = [];
    private readonly Environment $environment;
    private readonly MarkdownConverter $converter;

    public function __construct(?MarkdownConverter $converter = null)
    {
        // Configure the Environment with all the CommonMark parsers/renderers
        $this->environment = new Environment($this->config);
        $this->environment->addExtension(new CommonMarkCoreExtension());
        $this->environment->addExtension(new AttributesExtension());
        $this->environment->addExtension(new DescriptionListExtension());
        $this->converter = $converter ?: new MarkdownConverter($this->environment);
    }

    /**
     * @throws CommonMarkException
     */
    public function convert(string $body): string
    {
        return $this->converter->convert($body);
    }
}
