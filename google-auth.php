<?php

    require __DIR__ . "/vendor/autoload.php";

    use Dotenv\Dotenv;
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    $client = new Google\Client;
    $client->setClientId($_ENV["CLIENT_ID"]);
    $client->setClientSecret($_ENV["CLIENT_SECRET"]);
    $client->setRedirectUri($_ENV["REDIRECT_URI"]);

    $client->addScope("email");
    $client->addScope("profile");

    $authUrl = $client->createAuthUrl();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Google Auth</title>
</head>
<body>
    <a href="<?php echo $authUrl; ?>">Sign in with Google</a>
</body>
</html>