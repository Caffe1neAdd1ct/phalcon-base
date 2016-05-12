<?php

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new Phalcon\DI\FactoryDefault();

/**
 * We register the events manager
 */
$di->set('dispatcher', function() use ($eventsManager, $profiler) {

    $dispatch = new Phalcon\Mvc\Dispatcher;
    $dispatch->setEventsManager($eventsManager);

    /**
     * Check if the user is allowed to access certain action using the SecurityPlugin
     */
    $eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin);
    /**
     * Handle exceptions and not-found exceptions using NotFoundPlugin
     */
    $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);


    return $dispatch;
});

$di->set('app', $app);

$di->set('security', function() {

    $security = new Phalcon\Security();
    $security->setWorkFactor(12);

    return $security;
}, true);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function() use ($app) {
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($app->url->baseUri);
    return $url;
});

/**
 * Setting up the view component
 */
$di->set('view', function () use ($app, $eventsManager) {

    $view = new \Phalcon\Mvc\View();

    $view->setViewsDir(APP_DIR . $app->application->viewsDir);

    $view->registerEngines(array(
        ".volt" => 'volt',
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    $view->setEventsManager($eventsManager);

    return $view;
}, true);

/**
 * Setting up volt
 */
$di->set('volt', function($view, $di) use ($app) {
    $volt = new Phalcon\Mvc\View\Engine\Volt($view, $di);
    $volt->setOptions(
            array(
                'compiledPath' => APP_DIR . $app->application->cacheDir . 'volt/',
                'compiledSeparator' => '_',
                'compiledExtension' => '.compiled',
                "compileAlways" => true
            )
    );
    $compiler = $volt->getCompiler();
    $compiler->addFunction('is_a', 'is_a');
    return $volt;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function() use ($app, $eventsManager) {
    $dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $app->database->adapter;
    $dbclass = new $dbclass(
            array(
        'host' => $app->database->host,
        'username' => $app->database->username,
        'password' => $app->database->password,
        'dbname' => $app->database->dbdir . $app->database->dbname
            )
    );
    $dbclass->setEventsManager($eventsManager);
    return $dbclass;
});

/**
 * Use memory cache for dev
 * Use APC cache for live
 */
$di->set('modelsMetadata', function() use ($app) {

    $metaCacheClass = 'Phalcon\Mvc\Model\MetaData\\' . $app->database->metaCache;
    $metaCacheClass = new $metaCacheClass(
            (isset($app->database->metaCacheOptions)) ? (array) $app->database->metaCacheOptions : []
    );
    return $metaCacheClass;
});


/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function() {
    $session = new Phalcon\Session\Adapter\Files(
        array(
            'uniqueId' => 'my-app-1'
        )        
    );
    $session->start();
    return $session;
});

/**
 * Register the flash service with custom CSS classes
 */
$di->set('flash', function() {
    return new Phalcon\Flash\Session(array(
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert',
    ));
});

/**
 * Register mail service
 */
$di->set('mail', function() {
    return new Mail\Mail();
});

$di->setShared('profiler', $profiler);

$di->setShared('pluginsManager', function($profiler, $eventsManager) {
    $pluginManager = new \Fabfuel\Prophiler\Plugin\Manager\Phalcon($profiler);
    $pluginManager->setEventsManager($eventsManager);
    $pluginManager->register();
});
