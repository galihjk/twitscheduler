<?php
function twitter__login(){
    $callback = f("get_config")("LOGIN_URL");
    // echo "<pre>callback=";print_r($callback);echo"</pre>";


    if (isset($_SESSION['oauth_token']) and !empty($_GET['oauth_verifier'])) {
        $oauth_token = $_SESSION['oauth_token'];
        unset($_SESSION['oauth_token']);

        $connection = f("twitter.connect")();
        
        $params = [
            "oauth_verifier" => $_GET['oauth_verifier'],
            'oauth_token' => $_GET['oauth_token']
        ];

        $access_token = $connection->oauth('oauth/access_token', $params);

        // echo "<pre>access_token=";print_r($access_token);echo"</pre>";

        $_SESSION['access_token'] = $access_token;

        // echo "asd";

    }
    else {
        
        $connection = f("twitter.connect")();

        $temporary_credentials = $connection->oauth('oauth/request_token', ["oauth_callback" => $callback]);

        $_SESSION['oauth_token'] = $temporary_credentials['oauth_token'];
        $_SESSION['oauth_token_secret'] = $temporary_credentials['oauth_token_secret'];

        $param = [
            'oauth_token' => $temporary_credentials['oauth_token'],
        ];
        if(!empty($_GET['newlogin'])){
            $param["force_login"] = "true";
        }

        $url = $connection->url('oauth/authenticate', $param);

        // echo "<a href='$url'>$url</a>";
        // REDIRECTING TO THE URL
        header('Location: ' . $url);
        exit();
    }

    header('Location: index.php');
}
