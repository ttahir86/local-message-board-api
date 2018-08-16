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
        $maxDistance = $request->maxDistance;

        if ($lat != "") {
            $db = new DBConnect();

            $data = array
            (
                "title" => $title,
                "latitude" => $lng,
                "longitude" => $lat,
                "createDate" => "NOW()",
                "updateDate" => "NOW()",
                "numberOfMessages" => 0,

            );
            $sql = "SELECT
            MessageBoardId,Title,latitude,longitude, (
              3959 * acos (
                cos ( radians($lat) )
                * cos( radians( latitude ) )
                * cos( radians( longitude ) - radians($lng) )
                + sin ( radians($lat) )
                * sin( radians( latitude ) )
              )
            ) AS distance
          FROM Boards
          HAVING distance <$maxDistance
          ORDER BY distance
          LIMIT 0 , 20;";


            $db->openConnection();
            $results = $db->rawSelect($sql);
            
            $db->closeConnection();
            echo json_encode($results);

        }
        else {
            echo "Empty username parameter!";
        }
    }
    else {
        echo "Not called properly with username parameter!";
    }
?>