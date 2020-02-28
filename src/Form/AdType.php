<?php

namespace App\Form;

use App\Entity\Ad;

use App\Form\Configration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends Configration
{
    // private function attr($label,$placeholder,$option=[]){
    //    return array_merge( [
    //        'label'=>$label,
    //        'attr'=>['placeholder'=>$placeholder]
    //    ],$option);
    // }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,$this->attr('title','enter your title'))
            ->add('description',TextareaType::class,$this->attr('description','enter the description'))
            ->add('content',TextareaType::class,$this->attr('content','enter content'))
            ->add('publish',CheckboxType::class,$this->attr('publish','enter your title'))
            ->add('price',MoneyType::class,$this->attr('price','enter your title'))
            ->add('slug',TextType::class,$this->attr('slug','enter your title',['required'=>false]))
            ->add('startDate',DateType::class,$this->attr('start Date','enter your title'))
            ->add('endDate',DateType::class,$this->attr('end date','enter your title'))
            ->add('solid',PercentType::class,$this->attr('solid','enter your title'))
            ->add('location',CountryType::class,$this->attr('location','enter your title'))
            ->add('coverImage',UrlType::class,$this->attr('cover image','enter your title'))
            ->add('images',CollectionType::class,[
                'entry_type'=>ImageType::class,
                'allow_add'=>true,
                'allow_delete'=>true
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
