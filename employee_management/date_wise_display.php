<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Search</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Search Employees by Joining Date and Department</h2>

    <form action="date_wise_display.php" method="post">
        <div class="mb-3">
            <label for="from_date" class="form-label">From Date:</label>
            <input type="date" name="from_date" id="from_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="to_date" class="form-label">To Date:</label>
            <input type="date" name="to_date" id="to_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="department_id" class="form-label">Department:</label>
            <select name="department_id" id="department_id" class="form-select" required>
                <option value="">Select Department</option>
                <?php
                include('connection.php');
                $result = mysqli_query($conn, "SELECT * FROM departments");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['department_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="text-center">
            <input type="submit" value="Search" class="btn btn-primary">
        </div>
    </form>

    <br><br>

    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Salary</th>
                <th>Joining Date</th>
                <th>Profile Pictures</th>
            </tr>
        </thead>
    <tbody>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $department_id = $_POST['department_id'];

        if (empty($from_date) || empty($to_date) || empty($department_id)) {
            echo "<div class='alert alert-danger'>All fields are required.</div>";
        } 
        else 
        {
            $sql = "
                SELECT e.name, 
                e.profile_picture, 
                d.department_name, 
                e.email, 
                e.phone, 
                e.dob,
                e.salary, e.joining_date 
                FROM employees e
                JOIN departments d ON e.department_id = d.id
                WHERE e.joining_date BETWEEN '$from_date' AND '$to_date'
                AND e.department_id = '$department_id'
                ORDER BY e.joining_date ASC
            ";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) 
            {

                while ($row = mysqli_fetch_assoc($result)) 
                {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['department_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['joining_date']) . "</td>";
                    echo "<td>";
                    $profilePics = explode(",", $row['profile_picture']);
                    foreach ($profilePics as $pic) 
                    {
                        if (!empty($pic)) 
                        {
                            echo "<img src='uploads/" . htmlspecialchars($pic) . "' width='50' class='img-fluid rounded' style='margin-right: 5px;'>";
                        }
                    }
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } 
            else 
            {
                echo "<div class='alert alert-warning'>No employees found matching the criteria.</div>";
            }
        }
    }
    ?>

</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
