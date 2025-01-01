<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>
<body>

<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

include('connection.php');

$nameErr = $deptErr = $profilepicErr = $emailErr = $phoneErr = $dobErr = $salaryErr = "";
$name = $department_id = $profilepic = $email = $phone = $dob = $salary = "";
$valid = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (empty($_POST['name'])) 
    {
        $nameErr = "Employee name is required";
        $valid = false;
    } 
    else 
    {
        $name = $_POST['name'];
        if (!preg_match("/^[a-zA-Z' ]+$/", $name)) 
        {
            $nameErr = "Only letters and white space allowed";
            $valid = false;
        }
    }

    if (empty($_POST['department_id'])) 
    {
        $deptErr = "Department is required";
        $valid = false;
    } 
    else 
    {
        $department_id = $_POST['department_id'];
    }

    if (empty($_POST['email'])) 
    {
        $emailErr = "Email is required";
        $valid = false;
    } 
    else 
    {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $emailErr = "Invalid email format";
            $valid = false;
        }
    }

    if (empty($_POST['phone'])) 
    {
        $phoneErr = "Phone number is required";
        $valid = false;
    } 
    else 
    {
        $phone = $_POST['phone'];
        if (!preg_match("/^[0-9]{10}$/", $phone)) 
        {
            $phoneErr = "Invalid phone number";
            $valid = false;
        }
    }

    if (empty($_POST['dob'])) 
    {
        $dobErr = "Date of birth is required";
        $valid = false;
    } 
    else 
    {
        $dob = $_POST['dob'];
    }

    // Salary field validation
    if (empty($_POST['salary'])) 
    {
        $salaryErr = "Salary is required";
        $valid = false;
    }
    else 
    {
        $salary = $_POST['salary'];
        if (!is_numeric($salary)) 
        {
            $salaryErr = "Salary must be a number";
            $valid = false;
        }
    }

    if (isset($_FILES["profilepic"]) && !empty($_FILES["profilepic"]["name"])) 
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["profilepic"]["tmp_name"]);

        if ($check === false)   
        {
            $profilepicErr = "File is not an image.";
            $valid = false;
        } 
        elseif ($_FILES["profilepic"]["size"] > 5000000) 
        {
            $profilepicErr = "File size exceeds the 5MB limit.";
            $valid = false;
        } 
        elseif (!in_array($image_file_type, ["jpg", "jpeg", "png", "gif"])) 
        {
            $profilepicErr = "Only JPG, JPEG, PNG & GIF files are allowed.";
            $valid = false;
        } 
        elseif (file_exists($target_file)) 
        {
            $profilepicErr = "File already exists.";
            $valid = false;
        } 
        else 
        {
            if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) 
            {
                $profilepic = basename($_FILES["profilepic"]["name"]);
            } 
            else 
            {
                $profilepicErr = "Error uploading file.";
                $valid = false;
            }
        }
    }

    if ($valid && empty($profilepicErr)) 
    {
        $sql = "INSERT INTO employees (name, department_id, profile_picture, email, phone, dob, salary, joining_date) 
                VALUES ('$name', '$department_id', '$profilepic', '$email', '$phone', '$dob', '$salary', NOW())";

        if (mysqli_query($conn, $sql)) 
        {
            echo "Employee added successfully.";
            header("Location: display.php");
        } 
        else 
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add Employee</h2>
    <div class="text-end mb-3">
        <button type="button" class="btn btn-success" onclick="popup();">Add Department</button>
    </div>

    <div id="pop" style="display: none;">
        <form action="load_departments.php" method="post">
            <div class="mb-3">
                <label for="department_name" class="form-label">Enter the department name:</label>
                <input type="text" id="department_name" name="department_name" class="form-control"/>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Add Department</button>
            </div>
        </form>
    </div>

    <form action="insert_data.php" method="post" enctype="multipart/form-data" class="mt-4">

        <div class="mb-3">
            <label for="name" class="form-label">Employee Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" class="form-control">
            <span class="text-danger"><?php echo $nameErr; ?></span>
        </div>

        <div class="mb-3">
            <label for="department_id" class="form-label">Department:</label>
            <select name="department_id" id="department_id" class="form-select">
                <option value="">Select Department</option>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM departments");
                while ($row = mysqli_fetch_array($result)) 
                {
                    echo "<option value='" . $row['id'] . "' " . ($department_id == $row['id'] ? 'selected' : '') . ">" . $row['department_name'] . "</option>";
                }
                ?>
            </select>
            <span class="text-danger"><?php echo $deptErr; ?></span>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control">
            <span class="text-danger"><?php echo $emailErr; ?></span>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>" class="form-control">
            <span class="text-danger"><?php echo $phoneErr; ?></span>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth:</label>
            <input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($dob); ?>" class="form-control">
            <span class="text-danger"><?php echo $dobErr; ?></span>
        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Salary:</label>
            <input type="number" name="salary" id="salary" value="<?php echo htmlspecialchars($salary); ?>" class="form-control">
            <span class="text-danger"><?php echo $salaryErr; ?></span>
        </div>

        <div class="mb-3">
            <label for="profilepic" class="form-label">Profile Picture:</label>
            <input type="file" name="profilepic" id="profilepic" class="form-control">
            <span class="text-danger"><?php echo $profilepicErr; ?></span>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Add Employee</button>
        </div>

    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function popup() {
        document.getElementById('pop').style.display = 'block';
    }
</script>

</body>
</html>
