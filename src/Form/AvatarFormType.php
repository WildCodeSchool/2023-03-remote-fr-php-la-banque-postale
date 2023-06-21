<?php

namespace App\Form;

use App\Entity\Avatar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

class AvatarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatar', EntityType::class, [
                'label' => 'Choisissez un avatar',
                'class' => Avatar::class,
                'choice_label' => function (Avatar $avatar) {
                    $label = '<img src="/build/avatars/' . $avatar->getPath() . '">' . $avatar->getName();
                    return $label;
                },
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
