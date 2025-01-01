<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_name = $_POST['department_name'];

    if (!empty($department_name)) 
    {
        $sql = "INSERT INTO departments (department_name) VALUES ('$department_name')";

        if (mysqli_query($conn, $sql)) 
        {
            header('Location: insert_data.php');
        } 
        else 
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } 
    else 
    {
        echo "Department name is required.";
    }
}
?>
