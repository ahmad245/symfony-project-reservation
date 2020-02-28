<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigBootrapExtensions extends AbstractExtension{

    public function getFilters(){
        return [new TwigFilter('badge',[$this,'badgeFilter'])];
    }

    public function badgeFilter($content,array $option=[]){
        $defaultOption=[
            'color'=>'primary',
            'rounded'=>false
        ];
        $option=array_merge($defaultOption,$option);
        $color=$option['color'];
        $rounded=$option['rounded'] ? 'badge-pill' : '';
        return '<span class="badge badge-'.$color.' '.$rounded.'  ">'.$content.'</span>';
    }
}