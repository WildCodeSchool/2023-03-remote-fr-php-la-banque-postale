<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez taper votre nouveau mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit comporter au moins {{ 6 }} caractères.',
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'Taper votre nouveau mot de passe',
                    'label_attr' => ['class' => 'p-2'],
                    'attr' => [
                        'class' => 'text-light bg-warning form-control border-0',
                        'placeholder' => 'Tape ton mot de passe ici'
                    ],
                ],
                'second_options' => [
                    'label' => 'Répéter votre mot de passe',
                    'label_attr' => ['class' => 'p-2'],
                    'attr' => [
                        'class' => 'text-light bg-warning form-control border-0',
                        'placeholder' => 'Répète ton mot de passe ici'
                    ],

                ],
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
