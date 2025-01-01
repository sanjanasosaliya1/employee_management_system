<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Employee by Name</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Search Employee by Name</h2>

    <form action="search_name.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Enter the Employee Name:</label>
            <input type="text" id="name" name="name" class="form-control" required />
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

        include('connection.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            
            $sql = "
                SELECT e.profile_picture, e.name AS employee_name, e.email, e.phone, e.dob, e.salary, e.joining_date, d.department_name
                FROM employees e
                JOIN departments d ON e.department_id = d.id
                WHERE e.name LIKE '%$name%' 
                ORDER BY e.name ASC
            ";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>";
                    $profile_pic = explode(',', $row['profile_picture']);
                    foreach ($profile_pic as $pic) {
                        if ($pic) {
                            echo "<img src='uploads/" . htmlspecialchars($pic) . "' width='50' class='img-thumbnail'>";
                        }
                    }
                    echo "</td>";
                    echo "<td>" . htmlspecialchars($row["employee_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["dob"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["salary"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["joining_date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["department_name"]) . "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No results found for '$name'</td></tr>";
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
