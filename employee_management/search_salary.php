<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search by Salary</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Search Employees by Salary Range</h2>

    <form action="search_salary.php" method="post" class="mt-4">
        <div class="mb-3">
            <label for="maxsalary" class="form-label">Select Maximum Salary:</label>
            <input type="number" id="maxsalary" name="maxsalary" class="form-control" required />
        </div>
        
        <div class="mb-3">
            <label for="minsalary" class="form-label">Select Minimum Salary:</label>
            <input type="number" id="minsalary" name="minsalary" class="form-control" required />
        </div>

        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>Employee Profile</th>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Employee Phone</th>
                <th>Employee DOB</th>
                <th>Salary</th>
                <th>Joining Date</th>
                <th>Department Name</th>
            </tr>
        </thead>
        <tbody>

        <?php
        include("connection.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $maxsalary = $_POST['maxsalary'];
            $minsalary = $_POST['minsalary'];

            $sql = "
                SELECT e.profile_picture, e.name AS employee_name, e.email, e.phone, e.dob, e.salary, e.joining_date, d.department_name
                FROM employees e
                JOIN departments d ON e.department_id = d.id
                WHERE e.salary BETWEEN LEAST('$minsalary', '$maxsalary') AND GREATEST('$minsalary', '$maxsalary')
                ORDER BY e.salary ASC
            ";
            
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>";
                    $profile_pic = explode(",", $row['profile_picture']);
                    foreach ($profile_pic as $pic) {
                        if ($pic) {
                            echo "<img src='uploads/" . $pic . "' width='50' class='img-thumbnail'>";
                        }
                    }
                    echo "</td>";
                    echo "<td>" . $row["employee_name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["phone"] . "</td>";
                    echo "<td>" . $row["dob"] . "</td>";
                    echo "<td>" . $row["salary"] . "</td>";
                    echo "<td>" . $row["joining_date"] . "</td>";
                    echo "<td>" . $row["department_name"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No data found</td></tr>";
            }
        }
        ?>

        </tbody>
    </table>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
