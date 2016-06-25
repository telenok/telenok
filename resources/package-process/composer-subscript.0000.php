<?php

    \Telenok\Core\Support\Install\ComposerScripts::recursiveCopy(__DIR__ . "/../../", __DIR__ . "/../../../../../");
    \Telenok\Core\Support\Install\ComposerScripts::mergeRootComposerJson([
        "autoload" => [
            "classmap" => ["database"],
            "psr-4" => ["App\\" => "app/"]
        ]
    ]);

    $loader = require base_path() . '/vendor/autoload.php';
    $loader->set('App\\', "app/");
