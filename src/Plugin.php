<?php

namespace Pathologic\EvoTwig;

class Plugin {
    protected $modx;
    protected $params;
    protected $addonsPath = 'assets/plugins/evotwig/addons/';

    public function __construct(DocumentParser $modx, $params = [])
    {
        $this->modx = $modx;
        $this->params = $params;
    }

    protected function loadAddons($type)
    {
        $modx = $this->modx;
	    $twig = $this->modx->twig;
	    $path = $this->addonsPath . $type . '/';

    }

    public function OnBeforeSaveWebPageCache()
    {

    }
}