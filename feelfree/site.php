<?php

    $scheme = $_SERVER['REQUEST_SCHEME'];
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    $fullUrl = $scheme.'://'.$host.$uri;

    $site_url = $scheme.'://'.$host.'/feelfree/';
    $site_mail = 'support@feelfree.com';
    $site_title = 'FeelFree';