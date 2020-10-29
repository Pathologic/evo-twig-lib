<?php


namespace Pathologic\EvoTwig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class EvoExtension extends AbstractExtension
{
    protected $modx;

    public function __construct(\DocumentParser $modx)
    {
        $this->modx = $modx;
    }

    public function getFunctions()
    {
        $functions = [];
        $functions[] = new TwigFunction('makeUrl', [
            $this,
            'makeUrl'
        ]);
        $functions[] = new TwigFunction('runSnippet', [
            $this->modx,
            'runSnippet'
        ]);
        $functions[] = new TwigFunction('parseChunk', [
            $this->modx->tpl,
            'parseChunk'
        ]);
        $functions[] = new TwigFunction('getChunk', [
            $this->modx,
            'getChunk'
        ]);

        return $functions;
    }

    public function getFilters()
    {
        $filters = [];
        $filters[] = new TwigFilter('modxParser', [
            $this,
            'modxParser'
        ]);

        return $filters;
    }

    public function makeUrl($id, array $args = [], $absolute = true)
    {
        return $this->modx->makeUrl($id, '', http_build_query($args), $absolute ? 'full' : '');
    }

    public function modxParser($content)
    {
        $this->modx->minParserPasses = 2;
        $this->modx->maxParserPasses = 10;

        $out = $this->modx->tpl->parseDocumentSource($content, $this->modx);

        $this->modx->minParserPasses = -1;
        $this->modx->maxParserPasses = -1;

        return $out;
    }
}