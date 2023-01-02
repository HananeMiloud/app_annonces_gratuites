<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('phone', TextType::class,[
                'required' => false
            ])
            ->add('pays', TextType::class,[
                'required' => false
            ])
            ->add('ville', TextType::class,[
                'required' => false
            ])
            ->add('code_postal', TextType::class,[
                'required' => false
            ])
            ->add('region', TextType::class,[
                'required' => false
            ])
            ->add('description', TextType::class,[
                'required' => false
            ])
            ->add('image',FileType::class, [
                'label' => 'Image',
                'required' => true,
                'data_class' => null 
            ])
           
            ->add('submit', SubmitType::class, [
                'label' => "Update",
                'attr' => [
                   
                    'class'=>'btn  text-white mt-2 pull-right ',
                    'style' => 'width:200px; height:50px; border-radius: 0px;'
                ]
            ])
          
        ;
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
