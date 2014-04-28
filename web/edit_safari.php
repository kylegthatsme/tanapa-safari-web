<?php
    
    require('config/config.php');
    $safari = array();
    $waypoints = array();
    $points_of_interest = array();


    // Get safari details.
    $stmt = $db_conn->prepare("SELECT s.id, s.name, s.description, s.tile_media_id, s.header_media_id, s.footer_media_id, tm.url tile_media_url, hm.url header_media_url, fm.url footer_media_url FROM SAFARI s LEFT JOIN MEDIA tm ON tm.id = s.tile_media_id LEFT JOIN MEDIA hm ON hm.id = s.header_media_id LEFT JOIN MEDIA fm ON fm.id = s.footer_media_id WHERE s.id = ?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $stmt->bind_result($safari_id, $safari_name, $safari_description, $tile_media_id, $header_media_id, $footer_media_id, $tile_media_url, $header_media_url, $footer_media_url);
    $stmt->fetch();
    $safari["id"] = $safari_id;
    $safari["name"] = $safari_name;
    $safari["description"] = $safari_description;
    $safari["tile_media_id"] = $tile_media_id;
    $safari["header_media_id"] = $header_media_id;
    $safari["footer_media_id"] = $footer_media_id;
    $safari["tile_media_url"] = $tile_media_url;
    $safari["header_media_url"] = $header_media_url;
    $safari["footer_media_url"] = $footer_media_url;
    $stmt->close();


    // Get safari waypoints
    $stmt = $db_conn->prepare("SELECT id, sequence, latitude, longitude FROM SAFARI_WAYPOINTS WHERE SAFARI_ID = ?");
    $stmt->bind_param('i', $safari_id);
    $stmt->execute();
    $stmt->bind_result($waypoint_id, $sequence, $latitude, $longitude);
    
    while ($stmt->fetch()) {
        $waypoints[] = array(
            "id" => $waypoint_id,
            "sequence" => $sequence,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "safari_id" => $safari_id,
        );
    }
    $stmt->close();
    

    // Get safari points of interest
    $stmt = $db_conn->prepare("SELECT poi.id, poi.name, poi.latitude, poi.longitude, poi.radius, poi.safari_id, m.id poi_media_id, m.type poi_media_type, m.url poi_media_url FROM SAFARI_POINTS_OF_INTEREST poi LEFT JOIN MEDIA m on m.id = poi.media_id WHERE SAFARI_ID = ?");
    $stmt->bind_param('i', $safari_id);
    $stmt->execute();
    $stmt->bind_result($poi_id, $name, $latitude, $longitude, $radius, $safari_id, $poi_media_id, $poi_media_type, $poi_media_url);
    while ($stmt->fetch()) {
        $poi = array(
            "id" => $poi_id,
            "name" => $name,
            "latitude" => $latitude,
            "longitude" => $longitude, 
            "radius" => $radius,
            "safari_id" => $safari_id
        );

        if (!empty($poi_media_id)) {
            $media = array(
                "id" => $poi_media_id,
                "type" => $poi_media_type,
                "url" => $poi_media_url
            );
            $poi["media"] = $media;
        } 

        $points_of_interest[] = $poi;
    }
    $stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="page-header">
            <h1 style="padding-left: 15px;">TANAPA Safari <small>Edit Safari</small></h1>
        </div>
        <div class="container-fluid">
            <div class="col-md-6 col-md-offset-2">
                <form method="post" enctype="multipart/form-data">
                    <?php
                        echo "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" id=\"name\" placeholder=\"Name\" value=\"" . $safari["name"] . "\"/></div>";
                        echo "<div class=\"form-group\"><textarea rows=\"5\" class=\"form-control\" id=\"description\" placeholder=\"Description\">" . $safari["description"] . "</textarea></div>";
                        echo "<div class=\"form-group\"><label>Tile Image</label><input type=\"file\" id=\"tile_media\"/><img src=\"" . substr($safari["tile_media_url"], 1) . "\"/></div>";
                        echo "<div class=\"form-group\"><label>Header Image</label><input type=\"file\" id=\"header_media\"/><img src=\"" . substr($safari["header_media_url"], 1) . "\"/></div>";
                        echo "<div class=\"form-group\"><label>Footer Image</label><input type=\"file\" id=\"footer_media\"/><img src=\"" . substr($safari["footer_media_url"], 1) . "\"/></div>";
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Waypoints</div>
                        <table class="table table-striped">
                            <tr>
                                <th>Sequence</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                            </tr>
                            <?php
                                foreach($waypoints as $waypoint) {
                                    echo "<tr>";
                                    echo "<td>" . $waypoint["sequence"] . "</td>";
                                    echo "<td>" . $waypoint["latitude"] . "</td>";
                                    echo "<td>" . $waypoint["longitude"] . "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Points of Interest</div>
                        <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Radius</th>
                                <th>Image</th>
                            </tr>
                            <?php
                                foreach($points_of_interest as $poi) {
                                    $media_url = isset($poi["media"]) ? substr($poi["media"]["url"], 1) : null;
                                    $media_val = is_null($media_url) ? "<a href=\"" . $media_url . "\">" . $media_url . "</a>" : "&nbsp;";
                                    echo "<tr>";
                                    echo "<td>" . $poi["name"] . "</td>";
                                    echo "<td>" . $poi["latitude"] . "</td>";
                                    echo "<td>" . $poi["longitude"] . "</td>";
                                    echo "<td>" . $poi["radius"] . "</td>";
                                    echo "<td>" . $media_val . "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html