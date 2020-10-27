<?php namespace Pathologic\EvoTwig;
use Asm89\Twig\CacheExtension\CacheStrategy\KeyGeneratorInterface;

class KeyGenerator implements KeyGeneratorInterface{
    public function generateKey($value)
    {
        return $value;// . $value->getUpdatedAt();
    }
}