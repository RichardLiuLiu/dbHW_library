<?php
    $db = mysqli_connect('localhost', 'root', 'suar1508', 'hw3_library');
    if (mysqli_connect_errno()) {
        echo 'Database connection failed: '. mysqli_connect_error();
        die();
    }

    define('BASEURL', '/library/');
?>
