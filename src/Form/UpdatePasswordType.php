<?php

namespace App\Form;

use App\Form\Configration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatePasswordType extends Configration
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword',PasswordType::class,$this->attr('old password','enter the old password'))
            ->add('newPassword',PasswordType::class,$this->attr('new password','enter the new password'))
            ->add('confirmPassword',PasswordType::class,$this->attr('confirm password','enter the confirm password'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
