<?php 

require('config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // If no parameters were given, return list of Animal Groups

    if (empty($_GET)) {
        $results = array("results" => array());
        $stmt = $db_conn->prepare("SELECT ANIMAL_SPECIFIC.id, ANIMAL_SPECIFIC.name, ANIMAL_SPECIFIC.description, tile_media_id, TILE_MEDIA.type tile_media_type, TILE_MEDIA.url tile_media_url FROM ANIMAL_SPECIFIC JOIN MEDIA TILE_MEDIA ON TILE_MEDIA.id = ANIMAL_SPECIFIC.tile_media_id");
        $stmt->execute();
        $stmt->bind_result($group_id, $group_name, $group_description, $tile_media_id, $tile_media_type, $tile_media_url);
        while ($stmt->fetch()) {
            $results["results"][] = array(
                "id" => $group_id,
                "name" => $group_name,
                "description" => $group_description,
                "tile_media_id" => $tile_media_id,
                "tile_media_type" => $tile_media_type,
                "tile_media_url" => $tile_media_url
            );
        }
        $stmt->close();
        echo json_encode($results);

    } elseif (isset($_GET['id'])) {

        // Ifn ID is sent, retreive that animal groups's details and return them.
        $stmt = $db_conn->prepare("SELECT asp.id, asp.name, asp.description, ".
        	"asp.header_media_id, hm.type header_media_type, hm.url header_media_url, ".
        	"asp.footer_media_id, fm.type footer_media_type, fm.url footer_media_url, ".
        	"asp.tile_media_id, tm.type tile_media_type, tm.url tile_media_url FROM ANIMAL_SPECIFIC asp ".
        	"JOIN MEDIA hm ON hm.id = asp.header_media_id JOIN MEDIA fm ".
        	"ON fm.id = asp.footer_media_id JOIN MEDIA tm ON tm.id = ".
        	"asp.tile_media_id WHERE asp.id = ?");
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
        $stmt->bind_result($group_id, $group_name, $group_description, $header_media_id, $header_media_type, $header_media_url, $footer_media_id, $footer_media_type, $footer_media_url, $tile_media_id, $tile_media_type, $tile_media_url);
        $result = array();
        if ($stmt->fetch()){
            $result["id"] = $group_id;
            $result["name"] = $group_name;
            $result["description"] = $group_description;
            $result["header_media_id"] = $header_media_id;
            $result["header_media_type"] = $header_media_type;
            $result["header_media_url"] = $header_media_url;
            $result["footer_media_id"] = $footer_media_id;
            $result["footer_media_type"] = $footer_media_type;
            $result["footer_media_url"] = $footer_media_url;
            $result["tile_media_id"] = $tile_media_id;
            $result["tile_media_type"] = $tile_media_type;
            $result["tile_media_url"] = $tile_media_url;
        };

        $stmt->close();
        echo json_encode($result);
   }

}
?>
