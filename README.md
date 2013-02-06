How to Install
==============

Add IoAutosuggestBundle in your composer.json:

```js
{
    "require": {
        "ioalessio/autosuggestbundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update
```

Composer will install the bundle to your project's `vendor/ioalessio` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
    <?php
    // app/AppKernel.php
    
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Io\AutosuggestBundle\IoAutosuggestBundle(),
        );
    }
```

### Step 3: Configure the bundle

Add javascript files in your page (you can also put at the end of page) 

- bundles/ioautosuggest/twitter-bootstrap-typeahead.js
- bundles/ioautosuggest/autosuggest.js

IMPORTANT: it depends form bootstrap-typehead script

Add widget code in your form template file 

``` twig
    {# fields.html.twig #}
    {% extends 'form_div_layout.html.twig' %}
    {% block autosuggest_selector_widget %}
    {% spaceless %}
        {{ form_widget(form.autosuggest, { 'attr' : { 'class': 'ajax-typeahead ', 'data-value': form.value.vars['id'], 'data-link' : form.vars['attr']['url'] } } ) }}
        {{ form_widget(form.value) }}
        {{ form_rest(form) }}
    {% endspaceless %}
    {% endblock autosuggest_selector_widget %}

```

### Step 3: Include widget in a Form

``` php
    #FORM CLASS
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('field', 'autosuggest_selector', array(
            'entityName' => 'Acme\DemoBundle\Entity\MyEntity',
            'autocompleteMethod' => 'autocomplete',
            'valueMethod' => 'id',
            'route' => 'autosuggest_typehead'
            ));
        ...
    }
    
    #AUTOCOMPLETE CONTROLLER
    /**
     * @Route("/autosuggest.{_format}", name="autosuggest_typehead", defaults={"_format"="json"})
     */
    public function autosuggestAction()
    {
        $query = $this->getRequest()->get('query');
        
        $data = $this->getDoctrine()->getEntityManager()->createQuery("SELECT e.id, e.name AS name FROM AcmeDemoBundle:MyEntity e WHERE e.name LIKE :query)
                ->setParameter('query',  "%".$query."%")
                ->getArrayResult();                
        // array must countain 'id' and 'name' 
        $response = new Response(json_encode($data));
        return $response;
    }
```

