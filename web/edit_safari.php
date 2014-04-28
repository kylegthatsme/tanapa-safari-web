<?php
    
    require('config/config.php');
    $safari = array();
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
            <h1>TANAPA Safari <small>Edit Safari</small></h1>
        </div>
        <div class="container-fluid">
            <div class="col-md-6 col-md-offset-2">
                <form>
                    <?php
                        echo "<input type=\"text\" id=\"name\" placeholder=\"Name\" value=\"" . $safari["name"] . "\"/>";
                    ?>
                </form>
            </div>
        </div>
    </body>
</html