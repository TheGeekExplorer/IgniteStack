Frontend Plugin Injection
=========================

igniteStack can inject plugins straight into the view as it's being delivered to the user.

Plugins can be turned off and on in the config.php file situated in this directory.


Adding a new plugin
===================

Create the following dir structure in ./app/Plugins/Views/

- MyPlugin
  |- Assets
  |  |- header.html
  |  |- footer.html
  |- config.php

In config.php you should have an array like so :-

  $_PLUGIN = [
    'assets' => [
      'header' => 'header.html',
      'footer' => 'footer.html'
    ]
  ]
