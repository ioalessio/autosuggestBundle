<?php 

namespace Io\AutosuggestBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Io\AutosuggestBundle\Form\DataTransformer\AutosuggestTransformer;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutosuggestType extends AbstractType
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $om;
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */    
    private $router;

    /**
     * @param ObjectManager $om
     * @param RouterInterface $router
     */
    public function __construct(ObjectManager $om, RouterInterface $router)
    {
        $this->om = $om;
        $this->router = $router;
        
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $url = $this->router->generate($options['route'], $options['route_parameters']);                        
        $view->vars['attr']['url'] = $url;
     
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //devo prendere l'input text 
        $transformer = new AutosuggestTransformer($this->om, $options['entityName'], $options['valueMethod'], $options['autosuggestMethod']);

        $builder->addModelTransformer($transformer)
                ->add('value', 'hidden')
                ->add('autosuggest', 'text') 
                 ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('entityName'));
        $resolver->setRequired(array('route'));
        
        $resolver->setOptional(array('autosuggestMethod', 'valueMethod', 'route_parameters'));
        
        $resolver->setDefaults(array(
            'invalid_message' => 'Entity does not exists',
            'autosuggestMethod' => 'autocomplete',
            'valueMethod' => 'id',
            'route_parameters' => array()
            
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'autosuggest_selector';
    }
}
