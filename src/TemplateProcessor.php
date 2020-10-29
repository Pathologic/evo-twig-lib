<?php


namespace Pathologic\EvoTwig;


class TemplateProcessor
{
    protected $modx;
    protected $data = [];

    /**
     * @param  array  $data
     */
    public function setTemplateData(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getTemplateData()
    {
        return $this->data;
    }
}