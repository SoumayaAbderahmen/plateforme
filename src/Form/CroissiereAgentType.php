<?php

namespace App\Form;

use App\Entity\Croissiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Pays;
use App\Entity\AgenceVoyage;
use App\Entity\Hotel;
use App\Entity\Offre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CroissiereAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('titre')
            ->add('description')
            ->add('comprend')
            ->add('necomprendpas')
            ->add('prixapartir')
          
            ->add('pays', EntityType::class, [
                // looks for choices from this entity
                'class' => Pays::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                // 'expanded' => true,
            ])
           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Croissiere::class,
        ]);
    }
}
