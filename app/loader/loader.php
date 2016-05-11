<?php

$loader = new \Phalcon\Loader();

$loader->registerDirs(
    array(
        APP_DIR . $app->application->controllersDir,
        APP_DIR . $app->application->pluginsDir,
        APP_DIR . $app->application->vendorDir,
        APP_DIR . $app->application->modelsDir,
        APP_DIR . $app->application->formsDir,
        APP_DIR . $app->application->validatorsDir,
        APP_DIR . $app->application->libraryDir,
        APP_DIR . $app->application->migrationsDir,
    )
)->register();
