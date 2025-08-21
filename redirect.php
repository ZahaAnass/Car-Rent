<?php

    require __DIR__ . "/vendor/autoload.php";

    use Dotenv\Dotenv;
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $client = new Google\Client;
    $client->setClientId($_ENV["CLIENT_ID"]);
    $client->setClientSecret($_ENV["CLIENT_SECRET"]);
    $client->setRedirectUri($_ENV["REDIRECT_URI"]);

    if(!isset($_GET['code'])){
        exit("Login Failed");
    }

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    $client->setAccessToken($token['access_token']);

    $oauth = new Google\Service\Oauth2($client);

    $userinfo = $oauth->userinfo->get();

    var_dump(
        $userinfo->email,
        $userinfo->family_name,
        $userinfo->given_name,
        $userinfo->picture,
        $userinfo->name
    );

?>