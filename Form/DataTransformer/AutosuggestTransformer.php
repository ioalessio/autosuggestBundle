<?php

namespace Io\AutosuggestBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;


class AutosuggestTransformer implements DataTransformerInterface
{
    protected $om;

    protected $entityName;
    
    protected $valueMethod;
    
    protected $autosuggestMethod;
    
    
    /**
     * 
     * @param \Doctrine\Common\Persistence\ObjectManager $om
     * @param string $entityName
     * @param string $value
     * @param string $autosuggest
     */
    public function __construct(ObjectManager $om, $entityName, $value = "id", $autosuggest = "autocomplete")
    {
        $this->om = $om;

        $this->entityName = $entityName;
        $this->valueMethod = $value;
        $this->autosuggestMethod = $autosuggest;

        
    }

    /**
     * Transforms an object ($entity) to a string (id).
     *
     * @param  $entityName|null $entity
     * @return string
     */
    public function transform($entity)
    {
        if (null === $entity)
            return array("autosuggest" => '', 'value' => '');

        $autocompleteMethod = "get".ucfirst($this->getAutosuggestMethod());
        $valueMethod = "get".ucfirst($this->getValueMethod());
        
        return array(
            'autosuggest' => $entity->$autocompleteMethod(),
            'value'       => $entity->$valueMethod()
        );
        
    }

    /**
     * Transforms a string (string) to an object ($entity).
     *
     * @param  string $number
     * @return Cliente|null
     * @throws TransformationFailedException if object (Cliente) is not found.
     */
    public function reverseTransform($string)
    {
        $value = $string['value'];
        if (!$string) {
            return null;
        }

        $entity = $this->getOm()->createQuery("SELECT e FROM ".$this->getEntityName()." e WHERE e.id = :id")
                ->setParameter('id', $value)
                ->getSingleResult();

        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                'Entity does not exists "%s"!',
                $string
            ));
        }

        return $entity;
    }
    
    
    public function getOm() {
        return $this->om;
    }

    public function setOm($om) {
        $this->om = $om;
    }

    public function getEntityName() {
        return $this->entityName;
    }

    public function setEntityName($entityName) {
        $this->entityName = $entityName;
    }

    public function getValueMethod() {
        return $this->valueMethod;
    }

    public function setValueMethod($valueMethod) {
        $this->valueMethod = $valueMethod;
    }

    public function getAutosuggestMethod() {
        return $this->autosuggestMethod;
    }

    public function setAutosuggestMethod($autosuggestMethod) {
        $this->autosuggestMethod = $autosuggestMethod;
    }


}

?>