<?php

namespace App\Form;

use App\Entity\AddFriend;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChoiceFriendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('choice', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Accepter' => 'accept',
                    'Refuser' => 'decline',
                ],
                'expanded' => true,
                'multiple' => false,
                'choice_attr' => [
                    'class' => 'd-flex justify-content-between', // Ajoutez une classe Bootstrap pour la marge inférieure
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
