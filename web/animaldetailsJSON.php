

<?php 

require('config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET['id'])) {

        $results = array();

        $stmt = $db_conn->prepare("SELECT spec.id, spec.name, spec.description, spec.group_id, m.id spec_media_id, m.type spec_media_type, m.url spec_media_url FROM ANIMAL_SPECIFIC spec LEFT JOIN MEDIA m on m.id = spec.tile_media_id WHERE GROUP_ID = ?");
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
        $stmt->bind_result($spec_id, $name, $description, $group_id, $spec_media_id, $spec_media_type, $spec_media_url);
        while ($stmt->fetch()) {
            $spec = array(
                "id" => $spec_id,
                "name" => $name,
                "description" => $description,
                "group_id" => $group_id
            );

            if (!empty($spec_media_id)) {
                $media = array(
                    "id" => $spec_media_id,
                    "type" => $spec_media_type,
                    "url" => $spec_media_url
                );
                $spec["media"] = $media;
            } 

            $results["results"][] = $spec;
        }
        $stmt->close();

        echo json_encode($results);
    }

}

?>
