<?php include '../private/db_config.php' ?>
<?php
    $db = mysqli_connect('localhost', 'root', 'xxxxxx', 'hw3_library');
    if (mysqli_connect_errno()) {
        echo 'Database connection failed: '. mysqli_connect_error();
        die();
    }

    define('BASEURL', '/library/');
?>
