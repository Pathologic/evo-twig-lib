<?php

namespace Pathologic\EvoTwig;

class Plugin {
    protected $modx;
    protected $params;

    public function __construct(DocumentParser $modx, $params = [])
    {
	$this->modx = $modx;
	$this->params = $params;
    }

    protected function loadAddons()
    {
	$twig = $this->modx->twig;
    }

    protected function getTemplate()
    {
	
    }
}