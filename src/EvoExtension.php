<?php


namespace Pathologic\EvoTwig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class EvoExtension extends AbstractExtension implements GlobalsInterface
{
    protected $modx;
    protected $params = [];

    public function __construct(\DocumentParser $modx, array $params = [])
    {
        $this->modx = $modx;
        $this->params = $params;
    }

    public function getGlobals(): array
    {
        return [
            'modx'           => $this->modx,
            'documentObject' => $this->modx->documentObject,
            'resource'       => $this->getResource(),
            'debug'          => $this->params['debug'],
            'config'         => $this->modx->config,
            'ajax'           => isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest',
            '_GET'           => $_GET,
            '_POST'          => $_POST,
            '_REQUEST'       => $_POST,
            '_COOKIE'        => $_COOKIE,
        ];
    }

    public function getFunctions(): array
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

    public function getFilters(): array
    {
        $filters = [];
        $filters[] = new TwigFilter('modxParser', [
            $this,
            'modxParser'
        ]);

        return $filters;
    }

    public function makeUrl($id, array $args = [], $absolute = false): string
    {
        return $this->modx->makeUrl($id, '', http_build_query($args), $absolute ? 'full' : '');
    }

    public function modxParser($content): string
    {
        $this->modx->minParserPasses = 2;
        $this->modx->maxParserPasses = 10;

        $out = $this->modx->tpl->parseDocumentSource($content, $this->modx);

        $this->modx->minParserPasses = -1;
        $this->modx->maxParserPasses = -1;

        return $out;
    }

    private function getResource()
    {
        $resource = [];
        foreach ($this->modx->documentObject as $key => $value) {
            $resource[$key] = is_array($value) ? $value[1] : $value;
        }

        return $resource;
    }
}