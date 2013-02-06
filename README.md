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

Composer will install the bundle to your project's `vendor/gayalab` directory.

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

