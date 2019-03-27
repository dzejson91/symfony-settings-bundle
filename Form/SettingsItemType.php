<?php
/**
 * @author Krystian Jasnos <dzejson91@gmail.com>
 */

namespace JasonMx\SettingsBundle\Form;

use JasonMx\SettingsBundle\Entity\SettingsItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SettingsItemType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event)
    {
        /** @var Form $form */
        $form = $event->getForm();

        /** @var SettingsItem $data */
        $data = $event->getData();

        $required = true;

        $type = TextType::class;
        $options = array(
            'label' => $data->getKey(),
            'required' => $required,
            'trans' => !is_null($data->getLocale()),
        );

        if($required){
            $options['constraints'][] = new NotBlank();
        }

        if(!$this->parseType($data, $options, $type))
        {
            switch ($data->getType())
            {
                case 'email':{
                    $type = EmailType::class;
                    break;
                }

                case 'textarea':{
                    $type = TextareaType::class;
                    break;
                }

                case 'password':{
                    $type = PasswordType::class;
                    $options['attr'] = array(
                        'placeholder' => 'Ustaw nowe',
                    );
                    break;
                }

                case 'checkbox':{
                    $type = CheckboxType::class;
                    break;
                }

                case 'integer':{
                    $type = IntegerType::class;
                    break;
                }
            }
        }

        $form->add('value', $type, $options);
    }

    /**
     * For extend types
     *
     * @param SettingsItem $settingsItem
     * @param $options
     * @param $type
     * @return string
     */
    public function parseType(SettingsItem $settingsItem, &$options, &$type)
    {
        if($settingsItem && $options){
            $type = TextType::class;
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SettingsItem::class,
        ));
    }
}