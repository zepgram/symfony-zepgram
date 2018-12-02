<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'contact.label.email'
            ])
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'contact.label.name'
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'contact.label.message'
            ])
            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'send'],
                'label' => 'contact.label.send'
            ])
            ->add('reset', ResetType::class, [
                'label' => 'contact.label.reset'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
