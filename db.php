<?php

$conn = mysqli_connect("localhost", "root", "", "library");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>