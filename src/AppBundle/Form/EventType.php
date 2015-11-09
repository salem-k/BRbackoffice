<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Finder\Finder;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label','text',array(
              'label'             => 'Label',
              'attr'     => array(
                  'class'       => 'input-sm',
                  'width'=>'150px',
              ),
            ))
            ->add('text','text',array(
              'label'             => 'Text',
              'attr'     => array(
                  'class'       => 'input-sm',
                  'width'=>'150px',
              ),
            ))
            ->add('textcolor','text',array(
              'label'             => 'Text Color',
              'attr'     => array(
                  'class'       => 'input-sm',
                  'width'=>'150px',
              ),
            ))
            ->add('bgcolor','text',array(
              'label'             => 'Background Color',
              'attr'     => array(
                  'class'       => 'input-sm',
                  'width'=>'150px',
              ),
            ))
            ->add('image', 'choice', array(
              'empty_value' => 'No Image (select one)',
              'choices'  => $this->getFiles('image'),
              'required' => false
            ))
            ->add('sound', 'choice', array(
              'empty_value' => 'No Sound (select one)',
              'choices'  => $this->getFiles('sound'),
              'required' => false
            ))
            ->add('time','text',array(
              'label'             => 'Durée exécution',
              'attr'     => array(
                  'class'       => 'input-sm',
                  'width'=>'150px',
              ),
            ))
            ->add('sequence')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_event';
    }

    /**
    *
    * $type = image || sound
    */
    public function getFiles($type){

      $finder = new Finder();
      if($type == 'image')
        $finder->files()->name('*.jpg')->name('*.png')->in(__DIR__ . "/../../../web/uploads/");
      else
        $finder->files()->name('*.mp3')->name('*.wav')->in(__DIR__ . "/../../../web/uploads/");
      $return = Array();

      foreach ($finder as $file) {
        $return[$file->getBasename()] = $file->getBasename();
      }
      return $return;
    }
}
