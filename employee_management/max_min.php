<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Information</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2 class="text-center">Maximum Salary</h2>
    
    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>Employee Profile</th>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Salary</th>
                <th>Joining Date</th>
                <th>Department Name</th>
            </tr>
        </thead>
        <tbody>

        <?php

        include("connection.php");

        $sql = "
            SELECT e.profile_picture, e.name AS employee_name, e.email, e.salary, e.joining_date, d.department_name
            FROM employees e
            JOIN departments d ON e.department_id = d.id
            WHERE e.salary = (SELECT MAX(salary) FROM employees)
        ";
        
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>";
                $profile_pic = explode(",", $row['profile_picture']);
                foreach ($profile_pic as $pic) {
                    if ($pic) {
                        echo "<img src='uploads/" . htmlspecialchars($pic) . "' width='50' class='img-thumbnail'>";
                    }
                }
                echo "</td>";

                echo "<td>" . htmlspecialchars($row["employee_name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["salary"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["joining_date"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["department_name"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No data found</td></tr>";
        }

        ?>
        </tbody>
    </table>

    <h2 class="text-center mt-5">Minimum Salary</h2>
    
    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>Employee Profile</th>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Salary</th>
                <th>Joining Date</th>
                <th>Department Name</th>
            </tr>
        </thead>
        <tbody>

        <?php

        $sql = "
            SELECT e.profile_picture, e.name AS employee_name, e.email, e.salary, e.joining_date, d.department_name
            FROM employees e
            JOIN departments d ON e.department_id = d.id
            WHERE e.salary = (SELECT MIN(salary) FROM employees)
        ";
        
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                
                echo "<td>";
                $profile_pic = explode(",", $row['profile_picture']);
                foreach ($profile_pic as $pic) {
                    if ($pic) {
                        echo "<img src='uploads/" . htmlspecialchars($pic) . "' width='50' class='img-thumbnail'>";
                    }
                }
                echo "</td>";

                echo "<td>" . htmlspecialchars($row["employee_name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["salary"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["joining_date"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["department_name"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No data found</td></tr>";
        }

        ?>
        </tbody>
    </table>
    
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
