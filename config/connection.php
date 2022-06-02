<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'bincom');

    if(!$conn)
    {
        die(mysqli_error("Error"+$conn));
    }
?>