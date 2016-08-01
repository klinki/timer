<?php
namespace AppBundle\Form;

use AppBundle\Entity\LogEntry;
use AppBundle\Entity\Task;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CompleteLogEntryType extends AbstractType
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
        $user = $this->tokenStorage->getToken()->getUser();

        $builder
            ->add('text')
            ->add('task', EntityType::class, [
                'class' => 'AppBundle:Task',
                'choice_label' => 'name',
                'placeholder' => '===== SELECT TASK =====',
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('task')
                        ->where('task.owner = :user')
                        ->setParameter('user', $user)
                        ->orderBy('task.isDefault', 'DESC')
                        ->addOrderBy('task.name', 'ASC');
                }
            ])
            ->add('finish', CheckboxType::class, [
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LogEntry::class
        ]);
    }
}
