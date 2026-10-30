<?php

// Reads the database settings from environment variables (set them in Vercel);
// falls back to the local XAMPP defaults when they are not set.
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'php_project';
$db_port = (int)(getenv('DB_PORT') ?: 3306);

$conn = mysqli_init();

// Hosted MySQL providers require an encrypted connection.
if(getenv('DB_SSL')){
    mysqli_ssl_set($conn, null, null, null, null, null);
    $flags = MYSQLI_CLIENT_SSL;
}else{
    $flags = 0;
}

mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, $db_port, null, $flags)
        or die("Couldn't connect to database");

?>
