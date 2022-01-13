<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public $toolChoices = [
        'Aucun'=>'Aucun',
        'Cornue'=>'Cornue',
        'Alambic'=>'Alambic',
    ];

    public $levelChoices = [
        '0' => 0,
        '1' => 1,
        '2' => 2,
        '3' => 3,
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,
                ['label'=>'Email'])

            ->add('password', RepeatedType::class,
                ['type'=>PasswordType::class,
                    'invalid_message' => 'les mots de passe ne sont pas identiques',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'first_options'  => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Répétez le mot de passe']
                ])
            ->add('pseudo', TextType::class,)
            ->add('alchemistLevel', ChoiceType::class,
            [
                'placeholder' => 'Dérouler la liste',
                'choices' => $this->levelChoices,
            ])
            ->add('alchemistTool', ChoiceType::class,
                [
                    'placeholder' => 'Dérouler la liste',
                    'choices' => $this->toolChoices,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
