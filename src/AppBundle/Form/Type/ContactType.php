<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('send', SubmitType::class)
        ;
    }
}
