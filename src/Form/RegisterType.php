<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Configration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends Configration
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,$this->attr('First Name','enter your first name'))
            ->add('lastName',TextType::class,$this->attr('Last Name','enter your last name'))
            ->add('email',EmailType::class,$this->attr('Email','enter your  email'))
            ->add('picture',UrlType::class,$this->attr('Url Picture','enter your url picture'))
            ->add('password',PasswordType::class,$this->attr('Password','enter your password'))
            ->add('confirmPassword',PasswordType::class,$this->attr('Password','enter your password'))
            ->add('introduction',TextareaType::class,$this->attr('Introduction','enter your introduction'))
            ->add('bio',TextareaType::class,$this->attr('Bio','enter your bio'))
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
