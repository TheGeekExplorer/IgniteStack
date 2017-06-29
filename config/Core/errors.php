<?php

    $_ERRORS = [
        'DefaultError' => 'There was an unknown error.',
        'RouteNotSet' => 'The page you have asked for could not be found.',
        'Forbidden' => 'Forbidden',
        'ControllerExists' => 'The controller requested does not exist.',
        'ActionExists' => 'The action requested does not exist or could not be accessed in the controller.',
        'ViewExists' => 'The view requested does not exist or could not be loaded.',
        'FileExists' => 'The file requested does not exist or could not be loaded.',
        'ResourceExists' => 'The resource you requested does not exist or could not be accessed.',
        'NoRedirectURL' => 'No URL was passed when trying to redirect.',
        'DatasourceConfigIO' => 'Could not load the datasource configuration file.',
        'AssetDoesNotExist' => 'An asset that has been specified in the plugins configuration file does not exist.',
        'PluginConfigFiledoesNotExist' => 'Cannot load the config file for enabled plugin. File might not exist.',
        'CouldNotLoadPlugin' => 'Could not load a plugin.  Check whether the plugins have been configured correctly, and that they exist in the directory provided.',
        'SessionIdNoLength' => 'When generating a session ID you need to specify the output char length.',
        'QueryConstruction' => 'Not all of the required segments of the ORM query were present.',
        'ResponseCodeNotValid' => 'The response code given to the Response Class is not valid. Please check that it is set correctly in the ResponseCodes configuration file.',
        'HeaderTextNotSpecified' => 'You have tried to set a header using the Response Class however the header string provided is empty or not set.',
        'ViewNotSet' => 'The route that has been requested does not have a view or theme view set.'
    ];
