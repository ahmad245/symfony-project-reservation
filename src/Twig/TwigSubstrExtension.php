<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigSubstrExtension extends AbstractExtension{

    public function getFilters()
    {
        return [new TwigFilter('str',[$this,'strFilter'])];
    }

    public function strFilter($content, $length){
          
        return substr($content,0,$length);
    }
}