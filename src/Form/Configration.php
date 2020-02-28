<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;

class Configration extends AbstractType{
    protected function attr($label,$placeholder,$option=[]){
        return array_merge_recursive( [
            'label'=>$label,
            'attr'=>['placeholder'=>$placeholder]
        ],$option);
     }
}