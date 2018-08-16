<?php
    // allows for CORS request
    require_once('http.access.php');

    //http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
    $postdata = file_get_contents("php://input");
    if (isset($postdata)) {
        $request = json_decode($postdata);
        $lat = $request->lat;
        $lng = $request->lng;
        $radius = $request->radius;

        if ($lat != "") {
            echo "Server returns: " . $lat;
        }
        else {
            echo "Empty username parameter!";
        }
    }
    else {
        echo "Not called properly with username parameter!";
    }
?>