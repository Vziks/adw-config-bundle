<?php

namespace ADW\ConfigBundle\Form\Type;

use ADW\ConfigBundle\Entity\AllowIp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AllowIpType.
 * Project ConfigBundle.
 * @author Anton Prokhorov
 */
class AllowIpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('name', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => AllowIp::class
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'allowip';
    }
}
