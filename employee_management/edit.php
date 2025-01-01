<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
    include_once('connection.php');

    $id = $_GET['edit_id'];
    $sql = "SELECT * FROM employees WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) 
    {
        $row = mysqli_fetch_assoc($result);
        $username = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $dob = $row['dob'];
        $salary = $row['salary'];
        $department_id = $row['department_id'];
        $profile_picture = $row['profile_picture'];
        $joining_date = $row['joining_date'];
    } 
    else 
    {
        echo "<div class='alert alert-danger'>Employee not found!</div>";
        exit;
    }
?>

<div class="container mt-5">
    <h2 class="text-center">Edit Employee</h2>

    <form method="POST" action="update.php" enctype="multipart/form-data" class="mt-4">
        <input type="hidden" id="userid" name="userid" value="<?php echo $id; ?>">

        <div class="mb-3">
            <label for="username" class="form-label">Employee Name:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>" required>
        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Salary:</label>
            <input type="number" name="salary" id="salary" value="<?php echo htmlspecialchars($salary); ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label for="department_id" class="form-label">Department:</label>
            <select name="department_id" id="department_id" class="form-select" required>
                <option value="">Select Department</option>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM departments");
                while ($row = mysqli_fetch_array($result)) 
                {
                    echo "<option value='" . $row['id'] . "' " . ($department_id == $row['id'] ? 'selected' : '') . ">" . $row['department_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="profilepic" class="form-label">Profile Picture (optional):</label>
            <input type="file" name="profilepic[]" id="profilepic" class="form-control" multiple>
        </div>

        <div class="mb-3">
            <label>Existing Profile Pictures:</label>
            <div>
                <?php
                $profilePics = explode(",", $profile_picture);
                foreach ($profilePics as $pic) 
                {
                    if (!empty($pic)) 
                    {
                        echo "<img src='uploads/" . htmlspecialchars($pic) . "' class='img-thumbnail me-2' style='width: 50px; height: 50px;'>";
                    }
                }
                ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="joining_date" class="form-label">Joining Date:</label>
            <input type="date" class="form-control" name="joining_date" id="joining_date" value="<?php echo $joining_date; ?>" required>
        </div>

        <div class="text-center">
            <input type="submit" value="Update Employee" class="btn btn-primary">
        </div>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
