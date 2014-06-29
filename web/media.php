<?php
require('config/config.php');

$file_uploaded;
$mime_type;

// Handle multipart file uploads
if (isset ( $_FILES ['file'] )) {
    $file_uploaded = fopen($_FILES['file']['tmp_name'], "r");
    $mime_type = $_FILES['file']['type'];
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* PUT data comes in on the stdin stream */
    $file_uploaded = fopen("php://input", "r");

    /* Open a file for writing */
    $mime_type = $_SERVER["CONTENT_TYPE"];
}

$extension = $mime_type == "video/mp4" ? ".mp4" : ".jpg";
$new_path = "media/" . $_FILES['file']['name'];
$media_url = "/" . $new_path;
$fp = fopen($new_path, "w");

/* Read the data 1 KB at a time
   and write to the file */
while ($data = fread($file_uploaded, 1024)) {
    fwrite($fp, $data);
}

/* Close the streams */
fclose($fp);
fclose($file_uploaded);
chmod($new_path, 0755);

// insert into database.
$stmt = $db_conn->prepare("INSERT INTO MEDIA (type, url) VALUES(?, ?)");
$stmt->bind_param('ss', 
    $mime_type, 
    $media_url);
$stmt->execute();
$media_id = $db_conn->insert_id;
$stmt->close();

echo json_encode(array("id" => $media_id, "type" => $mime_type, "url" => $media_url));


?>
