<?php

# DEFAULT XML VIEW #
####################

    $XML_View = 'xml';


# LOGIN PAGE #
##############
    
    $route['/'] = [
        'controller'  =>  'com_mg_index',
        'action'      =>  'index',
        'view'        =>  'index',
        'method'      =>  'GET'
    ];
    

# DASHBOARD #
#############

    $route['/portal/'] = [
        'controller'  =>  'com_mg_portal',
        'action'      =>  'portal',
        'view'        =>  'portal/index',
        'method'      =>  'GET'
    ];

    $route['/portal/moderators/'] = [
        'controller'  =>  'com_mg_portal',
        'action'      =>  'moderators_portal',
        'view'        =>  'portal/moderators_portal',
        'method'      =>  'GET'
    ];

    $route['/portal/submission-successful/'] = [
        'controller'  =>  'com_mg_portal',
        'action'      =>  'submission_successful',
        'view'        =>  'portal/submission_successful',
        'method'      =>  'GET'
    ];


# API ACCESS #
##############

    $route['/api/auth/initialise'] = [            # Unused?
        'controller'  =>  'com_mg_api_auth',
        'action'      =>  'initialise',
        'view'        =>  'API/single_response',
        'method'      =>  'GET'
    ];

    $route['/api/auth/login'] = [
        'controller'  =>  'com_mg_api_auth',
        'action'      =>  'login',
        'view'        =>  'API/single_response',
        'method'      =>  'POST'
    ];

    $route['/api/pages/list-all'] = [
        'controller'  =>  'com_mg_api_pages',
        'action'      =>  'list_all',
        'view'        =>  'API/single_response',
        'method'      =>  'POST'
    ];

    $route['/api/pages/get-availability'] = [
        'controller'  =>  'com_mg_api_pages',
        'action'      =>  'get_availability',
        'view'        =>  'API/single_response',
        'method'      =>  'POST'
    ];

    $route['/api/adverts/save-new-proposal'] = [
        'controller'  =>  'com_mg_api_adverts',
        'action'      =>  'submit_new_proposal',
        'view'        =>  'API/single_response',
        'method'      =>  'POST'
    ];

    $route['/api/adverts/approve-advert-proposal'] = [
        'controller'  =>  'com_mg_api_adverts',
        'action'      =>  'approve_advert_proposal',
        'view'        =>  'API/single_response',
        'method'      =>  'POST'
    ];

    $route['/api/adverts/reject-advert-proposal'] = [
        'controller'  =>  'com_mg_api_adverts',
        'action'      =>  'reject_advert_proposal',
        'view'        =>  'API/single_response',
        'method'      =>  'POST'
    ];


# REPORTING ACCESS #
####################

    $route['/reporting/all-time'] = [
        'controller'  =>  'com_mg_reporting',
        'action'      =>  'all_time',
        'view'        =>  'API/single_response',
        'method'      =>  'GET'
    ];

    $route['/reporting/recently'] = [
        'controller'  =>  'com_mg_reporting',
        'action'      =>  'recently',
        'view'        =>  'API/single_response',
        'method'      =>  'GET'
    ];
