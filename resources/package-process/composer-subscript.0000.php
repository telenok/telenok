<?php

    \Telenok\Core\Support\Install\ComposerScripts::recursiveCopy(__DIR__ . "/../../", __DIR__ . "/../../../../../");
    \Telenok\Core\Support\Install\ComposerScripts::mergeRootComposerJson([
        "autoload" => [
            "classmap" => ["database"],
            "psr-4" => ["App\\" => "app/"]
        ]
    ]);

    $loader = $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';
    $loader->add('App\\', "app/");
