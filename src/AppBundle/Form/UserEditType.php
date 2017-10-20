<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('rolename')
            ->add('rolename', ChoiceType::class, array(
                    'label' => 'Définir son rôle',
                    'choices' => array(
                    'Simple utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                )
            ))
        ;
    }

    public function getParent()
    {
        return UserType::class;
    }
}
