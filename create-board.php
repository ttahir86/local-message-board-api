<?php
    // allows for CORS request
    require_once('http.access.php');
    require_once('my-libraries/db/db.bundle.php');

    //http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
    $postdata = file_get_contents("php://input");
    if (isset($postdata)) {
        $request = json_decode($postdata);
        $lat = $request->lat;
        $lng = $request->lng;
        $radius = $request->radius;
        $title  = $request->title;
        $message = $request->message;

        if ($lat != "") {
            $db = new DBConnect();

            $data = array
            (
                "title" => $title,
                "latitude" => $lat,
                "longitude" => $lng,
                "createDate" => "NOW()",
                "updateDate" => "NOW()",
                "numberOfMessages" => 0,

            );
            $db->openConnection();
            $db->insert("Boards", $data);
            $db->query();
            $db->closeConnection();
            echo "Server returns: " . $title;

        }
        else {
            echo "Empty username parameter!";
        }
    }
    else {
        echo "Not called properly with username parameter!";
    }
?>