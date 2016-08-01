<?php

namespace AppBundle\Form;

use AppBundle\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class TaskType extends AbstractType
{
    /** @var TokenStorage */
    protected $tokenStorage;

    /**
     * Constructor.
     *
     * @param TokenStorage $securityContext
     */
    public function __construct(TokenStorage $securityContext)
    {
        $this->tokenStorage = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('estimatedTime')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $resolver->setDefaults(array(
            'data_class' => Task::class,
            'empty_data' => function (FormInterface $form) use($user) {
                return new Task(
                    $form->getData()['name'],
                    $user
                );
            }
        ));
    }
}
