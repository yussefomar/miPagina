<?php

namespace Proyecto\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username')
                ->add('nombre')
                ->add('apellido')
                ->add('email','email')
                ->add('password','password')
                ->add('isActive')
                ->add('createdAt','hidden')
                ->add('updateAt','hidden')
                ->add('role','choice',array('choices'=>array('ROLE_ADMIN'=>'administrador','ROLE_USER'=>'usuario'),'placeholder'=>'elige una opcion'))
                ->add('save','submit',array('label'=>'crear Usuario'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Proyecto\UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'proyecto_userbundle_usuario';
    }


}
