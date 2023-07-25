<?php
    $host = '139.144.179.217:3306'; // Your host
    $db = 'rice_db'; // Your database
    $user = 'acgds'; // Your username
    $pass = 'C@pston3'; // Your password

    $maxAttempts = 8; // Maximum number of connection attempts
    $attempt = 0; // Current attempt counter
    $pdo = null; // PDO connection object

    while ($attempt < $maxAttempts) {
        try {
            // Attempt to establish a PDO connection
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            break; // If successful, exit the loop
        } catch (PDOException $e) {
            // Handle connection error
            $attempt++; // Increment the attempt counter
            if ($attempt >= $maxAttempts) {
                echo "Failed to connect to the database. Please try again later.";
                // You can also log the error message for debugging
                // error_log($e->getMessage());
                exit; // Stop further execution of the script
            }
            sleep(2); // Wait for 2 seconds before the next attempt
        }
    }

    // Define table and column names
    $tableName = "ektor";
    $column1Name = "Date";
    $column2Name = "rvi";
    $column3Name = "District";

    // SQL query to fetch average RVI by date and district
    $sql = "SELECT $column1Name AS date, AVG($column2Name) AS avg_rvi FROM $tableName GROUP BY $column1Name, $column3Name ORDER BY $column1Name ASC";
    $query = $pdo->prepare($sql);
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    // We'll encode this data in JSON format for use with Chart.js
    $jsonData = json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Average RVI Over Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chart-container {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <main role="main" class="container">
        <!-- Dashboard Section -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">RVI Over Time</h1>
        </div>

        <!-- Chart Section -->
        <div class="chart-container">
            <canvas class="my-4 border border-dark" id="rviChart" width="900" height="380"></canvas>
        </div>

        <!-- Graph Info Section -->
        <div class="graph-info bg-light p-4 rounded">
            <h3>RVI Over Time</h3>
            <p class="mb-0">This graph represents the average RVI (Rice Vegetation Index) over time. The X-axis shows the date, and the Y-axis represents the average RVI value. It provides insights into the variations in RVI throughout different dates and districts.</p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // JSON data
        var jsonData = <?php echo $jsonData; ?>;

        // Extract date, average RVI, and district data from the JSON
        var dates = [];
        var avgRviValues = [];

        jsonData.forEach(function(entry) {
            var date = entry.date;
            dates.push(date);
            avgRviValues.push(entry.avg_rvi);
        });

        // Define the chart
        var ctx = document.getElementById('rviChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Average RVI Over Time',
                    data: avgRviValues,
                    backgroundColor: 'rgba(104, 159, 56, 0.5)',
                    borderColor: 'rgba(68, 127, 39, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)' // Color of the grid lines
                        },
                        ticks: {
                            fontColor: 'rgba(0, 0, 0, 0.9)' // Color of the tick labels
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)' // Color of the grid lines
                        },
                        ticks: {
                            fontColor: 'rgba(0, 0, 0, 0.9)' // Color of the tick labels
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>

</html>
