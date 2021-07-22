<?php

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use App\Service\MarkdownParser;


class AppRuntime implements RuntimeExtensionInterface
{
    /**
     * @var MarkdownParser
     */
    private  $markdownParser;

    public function __construct(MarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parseMarkdown($content)
    {
        return $this->markdownParser->parse($content);
    }
}