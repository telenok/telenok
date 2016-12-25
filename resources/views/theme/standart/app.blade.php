<?php
ob_start();
?>
@if (isset($content['center']))
@foreach($content['center'] as $widget)
{!! $widget !!}
@endforeach
@endif

<?php
$htmlCode = ob_get_contents();

ob_end_clean();
?>

        <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>{{config('app.backend.brand')}}</title>
    <base href="http://{!! config('app.locale') !!}.mysite.com"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <?php
    $controllerRequest->addCssFile('file/css/all.css', ['bootstrap', 'font-awesome', 'fonts.googleapis', 'style', 'style-telenok'], 10);

    $controllerRequest->addJsFile('file/js/lib.js', ['lib'], 0);
    $controllerRequest->addJsFile('file/js/custom.js', ['custom'], 1);
    ?>

    @foreach($controllerRequest->getCssFile() as $file)

        <link href="{!! $file['file'] !!}" rel="stylesheet"/>

    @endforeach

    @foreach($controllerRequest->getCssCode() as $code)

        <style>

            {!! $code !!}

        </style>

    @endforeach
</head>

<body>

@section('top-menu')
    <?php
    echo app('\App\Vendor\Telenok\Core\Widget\Menu\Controller')
            ->setConfig([
                    'frontend_view' => 'theme::menu.menu-top',
                    'menu_type'     => 2,
                    'node_ids'      => '["page.home", "page.licenses", "page.account.dashboard"]',
                    'object_type'   => 'page',
                    'cache_key'     => 'custom.page-menu-top',
            ])->getContent();
    ?>
@show

@yield('content')

{!! $htmlCode !!}


<!-- CONTENT-WRAPPER SECTION END-->
<section class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script>
                Mysite.com
            </div>

        </div>
    </div>
</section>
<!-- FOOTER SECTION END-->


@foreach($controllerRequest->getJsFile() as $file)

    <script src="{!! $file['file'] !!}"></script>

@endforeach

@foreach($controllerRequest->getJsCode() as $code)

    {!! $code !!}

@endforeach

<script type="text/javascript">
    jQuery(function () {
        jQuery.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
    });
</script>

<script type="text/javascript">
    jQuery.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
        }
    });
</script>

<?php
    // Crossdomain auth
    app(\App\Vendor\Telenok\Core\Controller\Auth\AuthController::class)->getCrossDomainAuthUrl()->each(function($item)
    {
?>
    <script>
        jQuery(function() {
            jQuery.ajax({
                url: "{!! $item !!}",
                dataType: 'jsonp'
            });
        });
    </script>
<?php
    });
?>

</body>
</html>