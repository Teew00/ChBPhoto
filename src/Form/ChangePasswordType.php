<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe actuel',
            ])
            ->add('newPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Nouveau mot de passe',
            ]);

    }


    public function configureOptions(OptionsResolver $resolver)
    {
    }

}
