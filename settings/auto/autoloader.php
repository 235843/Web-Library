<?php

require_once __DIR__.'/../config/config.php';

spl_autoload_register(function() {
    require_once AUTH_PATH . '/Auth.php';
    require_once AUTH_PATH . '/Errors.php';
});

spl_autoload_register(function() {
    require_once ROUTES_PATH . '/Router.php';
});

spl_autoload_register(function() {
    require_once SESSION_PATH . '/Session.php';
});

spl_autoload_register(function() {
    require_once VIEWS_PATH . '/Home.php';
    require_once VIEWS_PATH . '/LoginForm.php';
    require_once VIEWS_PATH . '/Register.php';
    require_once VIEWS_PATH . '/About.php';
    require_once VIEWS_PATH . '/Profile.php';
    require_once VIEWS_PATH . '/Orders.php';
    require_once VIEWS_PATH . '/Password.php';
    require_once VIEWS_PATH . '/AddBook.php';
    require_once VIEWS_PATH . '/EditBook.php';
});

spl_autoload_register(function () {
    require_once ENDPOINTS_PATH . '/RegisterEndpoint.php';
    require_once ENDPOINTS_PATH . '/LoginEndpoint.php';
    require_once ENDPOINTS_PATH . '/ResultsEndpoint.php';
    require_once ENDPOINTS_PATH . '/LogoutEndpoint.php';
    require_once ENDPOINTS_PATH . '/OrderEndpoint.php';
    require_once ENDPOINTS_PATH . '/ReturnEndpoint.php';
    require_once ENDPOINTS_PATH . '/ChangeEndpoint.php';
    require_once ENDPOINTS_PATH . '/NewPasswordEndpoint.php';
    require_once ENDPOINTS_PATH . '/AddedBook.php';
    require_once ENDPOINTS_PATH . '/DeleteEndpoint.php';
    require_once ENDPOINTS_PATH . '/EditEndpoint.php';
});
