<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            transition: margin-left 0.3s;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            transition: transform 0.3s ease;
            transform: translateX(0);
        }
        .sidebar.hidden {
            transform: translateX(-250px);
        }
        .content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .content.shifted {
            margin-left: 0;
        }
        .sidebar .nav-link {
            font-size: 16px;
            padding: 10px 15px;
        }
        .sidebar .nav-link:hover {
            background-color: #007bff;
            color: white;
        }
        .close-btn {
            position: absolute;
            top: 20px;
            right: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php
include('connection.php');
?>

<div class="sidebar" id="sidebar">
    <!-- Sidebar content -->
    <h4 class="text-center">Dashboard</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="date_wise_display.php">Search by Joining Date</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="search_salary.php">Search by Salary</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="search_name.php">Search by name</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="max_min.php">Max-min salary</a>
        </li>

    </ul>
</div>

<div class="content" id="content">
    <h2 class="text-center">Employee Records
        <div class="text-end mb-3">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </h2>

    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Salary</th>
                <th>Profile Pictures</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $sql = "SELECT 
                    e.id, 
                    e.name, 
                    d.department_name, 
                    e.email, 
                    e.phone, 
                    e.dob,
                    e.salary, 
                    e.profile_picture 
                FROM employees e 
                JOIN departments d ON e.department_id = d.id";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['department_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
            echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
            echo "<td>" . htmlspecialchars($row['salary']) . "</td>";

            echo "<td>";
            $profilePics = explode(",", $row['profile_picture']);
            foreach ($profilePics as $pic) {
                if (!empty($pic)) {
                    echo "<img src='uploads/" . htmlspecialchars($pic) . "' class='img-thumbnail me-2' style='width: 50px; height: 50px;'>";
                }
            }
            echo "</td>";

            echo "<td>";
            echo '<a href="edit.php?edit_id=' . $row['id'] . '" class="btn btn-sm btn-warning">Edit</a> ';
            echo '<a href="delete.php?delete_id=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this employee?\')">Delete</a>';
            echo "</td>";

            echo "</tr>";
        }
        ?>

        </tbody>
    </table>

</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
