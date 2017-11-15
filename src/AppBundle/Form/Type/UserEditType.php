<?php

namespace AppBundle\Form\Type;

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
                    'label' => 'Changer ses droits',
                    'choices' => array(
                    'Ne pas changer de rôle' => null,
                    'Changer en simple utilisateur' => 'ROLE_USER',
                    'Changer en administrateur' => 'ROLE_ADMIN'
                )
            ))
        ;
    }

    public function getParent()
    {
        return UserType::class;
    }
}
