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

### Step 3: Configure the budnle

Add javascript files in your page (you can also put at the end of page) 

- bundles/ioautosuggest/twitter-bootstrap-typeahead.js
- bundles/ioautosuggest/autosuggest.js

IMPORTANT: it depends form bootstrap-typehead script

Add widget code in your form template file 

``` twig
{# fields.html.twig #}
{% extends 'form_div_layout.html.twig' %}
{% block autosuggest_widget %}
{% spaceless %}
    {{ form_widget(form.autosuggest, { 'attr' : { 'class': 'ajax-typeahead ', 'data-value': form.value.vars['id'], 'data-link' : form.vars['attr']['url'] } } ) }}
    {{ form_widget(form.value) }}
    {{ form_rest(form) }}
{% endspaceless %}
{% endblock autosuggest_widget %}

```
