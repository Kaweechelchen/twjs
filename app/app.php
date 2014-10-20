<?php

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    require_once __DIR__.'/bootstrap.php';

    $app = new Silex\Application();

    $app->mount( '/2014/', new twjson\jsonControllerProvider() );

    $app->after(function (Request $request, Response $response) {

        $response->headers->set('Access-Control-Allow-Origin', '*');

    });

    return $app;
