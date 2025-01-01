<?php
    include_once('connection.php');
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM employees WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) 
    {
        echo "<br> Id = " . $id . " is deleted successfully.";
    } 
    else 
    {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    header("Location: display.php");
    exit(); 
?>
