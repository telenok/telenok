<?php

app('router')->pattern('telenok_domain', '(' . implode('|',
        \App\Vendor\Telenok\Core\Model\Web\Domain::active()->get()->transform(function($item)
        {
            return preg_quote($item->domain);
        })->values()->all()
    ). ')');

app('router')->group(['domain' => '{telenok_domain}', 'middleware' => ['web']], function ()
{
    //app("router")->post("some-url", array("as" => "page.some-name", "uses" => '\App\Http\Controllers\Controller@someMethod'));

    require 'telenok.php';
});
