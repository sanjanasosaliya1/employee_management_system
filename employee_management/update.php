<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $id = $_POST['userid'];
    $name = $_POST['username'];
    $email = $_POST['email']; 
    $phone = $_POST['phone']; 
    $dob = $_POST['dob'];   
    $salary = $_POST['salary'];     
    $department_id = $_POST['department_id'];
    $joining_date = $_POST['joining_date'];
    $profilePics = [];

    if (isset($_FILES["profilepic"]) && !empty($_FILES["profilepic"]["name"][0])) 
    {
        $upload_directory = "uploads/";
        $allowed_files = ["jpg", "jpeg", "png", "gif"];
        $total_files = count($_FILES["profilepic"]["name"]);

        if (!is_dir($upload_directory)) 
        {
            mkdir($upload_directory, 0777, true);
        }

        for ($c = 0; $c < $total_files; $c++) 
        {
            if ($_FILES["profilepic"]["tmp_name"][$c]) 
            {
                $target_file = $upload_directory . basename($_FILES["profilepic"]["name"][$c]);
                $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (in_array($image_file_type, $allowed_files)) 
                {
                    if (move_uploaded_file($_FILES["profilepic"]["tmp_name"][$c], $target_file)) 
                    {
                        $profilePics[] = basename($_FILES["profilepic"]["name"][$c]);
                    }
                }
            }
        }
    }

    if (!empty($profilePics)) 
    {
        $profile_picture = implode(",", $profilePics);
        $sql = "UPDATE employees SET name='$name', email='$email', phone='$phone', dob='$dob', salary='$salary', department_id='$department_id', joining_date='$joining_date', profile_picture='$profile_picture' WHERE id='$id'";
    } 
    else 
    {
        $sql = "UPDATE employees SET name='$name', email='$email', phone='$phone', dob='$dob', salary='$salary', department_id='$department_id', joining_date='$joining_date' WHERE id='$id'";
    }

    if (mysqli_query($conn, $sql)) 
    {
        echo "Employee updated successfully!";
    } 
    else 
    {
        echo "Error updating employee: " . mysqli_error($conn);
    }

    header("Location: display.php");
    exit(); 
}
?>
