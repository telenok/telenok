<?php

    \Telenok\Core\Support\Install\ComposerScripts::recursiveCopy(__DIR__ . "/../../", __DIR__ . "/../../../../../");
    \Telenok\Core\Support\Install\ComposerScripts::mergeRootComposerJson([
        "classmap" => ["database"],
        "psr-4" => ["App\\" => "app/"]
    ]);
