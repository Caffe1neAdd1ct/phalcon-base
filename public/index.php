<?php

use Phalcon\Mvc\Application as Application;
use Phalcon\Config\Adapter\Ini as ConfigIni;

/** @todo remove these */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/** define the application directory */
define('APP_DIR', realpath(dirname(realpath(__FILE__)) . '/../app'));

try {
    $app = new ConfigIni(APP_DIR . '/config/app.ini');
    if (!$app instanceof ConfigIni) {
        throw new Exception("Config file app.ini missing or unable to be loaded.");
    }
    
    /** start composer autoloader */
    require_once ( APP_DIR . $app->application->vendorDir . '/autoload.php' );
    
    /** start prophiler */
    $profiler = new \Fabfuel\Prophiler\Profiler();
    $profiler->addAggregator(new \Fabfuel\Prophiler\Aggregator\Database\QueryAggregator());
    $profiler->addAggregator(new \Fabfuel\Prophiler\Aggregator\Cache\CacheAggregator());
    
    $eventsManager = new \Phalcon\Events\Manager();
    $eventsManager->attach('dispatch', Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin::getInstance($profiler));
    $eventsManager->attach('view', Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getInstance($profiler));
    $eventsManager->attach('db', Fabfuel\Prophiler\Plugin\Phalcon\Db\AdapterPlugin::getInstance($profiler));

    /** initilise the application */
    require_once ( APP_DIR . '/loader/loader.php' );
    require_once ( APP_DIR . '/loader/services.php' );
    
    /** Handle the request and process all phalcon framework logic */
    $application = new Application($di);
    $application->setEventsManager($eventsManager);
    
    echo $application->handle()->getContent();

    /** show pro toolbar */
    $toolbar = new \Fabfuel\Prophiler\Toolbar($profiler);
    $toolbar->addDataCollector(new \Fabfuel\Prophiler\DataCollector\Request());
    echo ($app->profiler->show) ? $toolbar->render() : null;
    
} catch (\Phalcon\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}