TANAPA Safari Web App
=====================


**How to Deploy the Web App**

* First you need to fork this repo to your account.

* Log into your server, run the following command from your home directory:
```
git clone https://github.com/<YOURGITHUBUSERNAME>/tanapa-safari-web
```

* Copy the php files over to your `public_html` directory:
```
cp -R -f web/* ~/public_html/
```

* Create your config folder and config file that will hold the db setup and set the correct permissions:
```
mkdir ~/public_html/config
touch ~/public_html/config/config.php
chmod 755 -R ~/public_html
```

* Edit `~/public_html/config/config.php` with your favorite editor and put in this data:
```
<?php

$db_host = "YOUR DB HOST";
$db_user = "YOUR DB USER";
$db_pass = "YOUR DB PASSWORD";
$db_name = "YOUR DB NAME";

$db_conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}

?>
```