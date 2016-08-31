<?php

$base_url = "http://localhost/ramalcuacaku/login.php";

$config = array("base_url" => $base_url, 
        "providers" => array ( 
            "Google" => array ( 
                "enabled" => true,
                "keys"    => array ( "id" => "YOUR_GOOGLE_API_KEY", "secret" => "YOUR_GOOGLE_API_SECRET" ), 
 
            ),
 
            "Facebook" => array ( 
                "enabled" => true,
                "keys"    => array ( "id" => "207844712900697", "secret" => "463c66682565f4b000cffa7a3d548e61" ),
                "scope" => "email, user_about_me, user_birthday, user_hometown"  //optional.              
            ),
 
           /* "Twitter" => array ( 
                "enabled" => true,
                "keys"    => array ( "key" => "TWITTER_DEVELOPER_KEY", "secret" => "TWITTER_SECRET" ) 
            ),*/
        ),
        // if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
        "debug_mode" => false,
        "debug_file" => "debug.log",
    );