<?php
    $host = '139.144.179.217:3306'; // your host
    $db = 'rice_db'; // your database
    $user = 'acgds'; // your username
    $pass = 'C@pston3'; // your password

    $maxAttempts = 8; // maximum number of connection attempts
    $attempt = 0; // current attempt counter
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
    $tableName = "RiceCrop";
    $column1Name = "DateOfHarvest";
    $column2Name = "RiceYield";

    // SQL query to fetch distinct days of harvest
    $distinctDaysSql = "SELECT DISTINCT $column1Name FROM $tableName ORDER BY $column1Name ASC";
    $distinctDaysQuery = $pdo->prepare($distinctDaysSql);
    $distinctDaysQuery->execute();
    $distinctDays = $distinctDaysQuery->fetchAll(PDO::FETCH_COLUMN);

    // Get the minimum and maximum days of harvest
    $minDay = min($distinctDays);
    $maxDay = max($distinctDays);

    // SQL query to aggregate data by day of harvest and calculate average yield
    $sql = "SELECT $column1Name AS day, AVG($column2Name) AS average_yield FROM $tableName GROUP BY $column1Name ORDER BY $column1Name ASC";
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
    <title>Rice Yield Over Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chart-container2 {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <main role="main" class="container">
        <!-- Dashboard Section -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Rice yield over time</h1>
        </div>

        <!-- Filter Section -->
        <div class="filter-container">
            <label for="fromDate">From:</label>
            <select id="fromDate" class="form-select">
                <?php
                    foreach ($distinctDays as $day) {
                        echo "<option value='$day'>$day</option>";
                    }
                ?>
            </select>
            <label for="toDate">To:</label>
            <select id="toDate" class="form-select">
                <?php
                    foreach ($distinctDays as $day) {
                        echo "<option value='$day'>$day</option>";
                    }
                ?>
            </select>
        </div>

        <!-- Chart Section -->
        <div class="chart-container2">
            <canvas class="my-4 border border-dark" id="yieldChart2" width="900" height="380"></canvas>
        </div>

        <!-- Graph Info Section -->
        <div class="graph-info bg-light p-4 rounded">
            <h3>Rice yield over time</h3>
            <p class="mb-0">This graph represents the average rice yield over time. The X-axis shows the days of harvest, and the Y-axis represents the yield in tons/hectare. It provides insights into the variations in rice yield throughout different days of harvest.</p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // JSON data
        var jsonData2 = <?php echo $jsonData; ?>;

        // Extract days of harvest and yield data from the JSON
        var days2 = [];
        var yields2 = [];

        jsonData2.forEach(function(entry) {
            var day = entry.day;
            days2.push(day);
            yields2.push(entry.average_yield);
        });

        // Define the chart
        var ctx2 = document.getElementById('yieldChart2').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: days2,
                datasets: [{
                    label: 'Rice Yield Over Time',
                    data: yields2,
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

        // Filter event listener
        var fromDateSelect = document.getElementById('fromDate');
        var toDateSelect = document.getElementById('toDate');

        fromDateSelect.addEventListener('change', function() {
            var selectedFromDate = fromDateSelect.value;
            var selectedToDate = toDateSelect.value;

            updateChart(selectedFromDate, selectedToDate);
        });

        toDateSelect.addEventListener('change', function() {
            var selectedFromDate = fromDateSelect.value;
            var selectedToDate = toDateSelect.value;

            updateChart(selectedFromDate, selectedToDate);
        });

        function updateChart(fromDate, toDate) {
            var filteredDays = [];
            var filteredYields = [];

            jsonData2.forEach(function(entry) {
                var day = entry.day;
                if (day >= fromDate && day <= toDate) {
                    filteredDays.push(day);
                    filteredYields.push(entry.average_yield);
                }
            });

            myChart2.data.labels = filteredDays;
            myChart2.data.datasets[0].data = filteredYields;
            myChart2.update();
        }
    </script>
</body>

</html>

<?php
    $host = '139.144.179.217:3306'; // your host
    $db = 'rice_db'; // your database
    $user = 'acgds'; // your username
    $pass = 'C@pston3'; // your password

    $maxAttempts = 8; // maximum number of connection attempts
    $attempt = 0; // current attempt counter
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
    $tableName = "RiceCrop";
    $column1Name = "Season"; // Replace with the actual column name
    $column2Name = "RiceYield";

    // SQL query to fetch distinct districts
    $distinctDistrictsSQL = "SELECT District FROM (SELECT DISTINCT District FROM $tableName) AS tmp";
    $distinctDistrictsQuery = $pdo->prepare($distinctDistrictsSQL);
    $distinctDistrictsQuery->execute();
    $distinctDistricts = $distinctDistrictsQuery->fetchAll(PDO::FETCH_COLUMN);

    // Default selected district
    $selectedDistrict = isset($_GET['district']) ? $_GET['district'] : $distinctDistricts[0];


    // Default selected district
    $selectedDistrict = isset($_GET['district']) ? $_GET['district'] : $distinctDistricts[0];

    // SQL query to fetch data for SA and WS seasons
    $saWsSQL = "SELECT $column1Name, YEAR($column1Name) AS year, AVG($column2Name) AS average_yield FROM $tableName WHERE $column1Name IN ('SA', 'WS') GROUP BY $column1Name, YEAR($column1Name) ORDER BY $column1Name ASC";
    $saWsQuery = $pdo->prepare($saWsSQL);
    $saWsQuery->execute();
    $saWsData = $saWsQuery->fetchAll(PDO::FETCH_ASSOC);

    // JSON data for SA and WS seasons
    $saWsJsonData = json_encode($saWsData);

    // SQL query to fetch data for the selected district
    $districtSQL = "SELECT $column1Name, YEAR($column1Name) AS year, AVG($column2Name) AS average_yield FROM $tableName WHERE District = ? GROUP BY $column1Name, YEAR($column1Name) ORDER BY $column1Name ASC";
    $districtQuery = $pdo->prepare($districtSQL);
    $districtQuery->execute([$selectedDistrict]);
    $districtData = $districtQuery->fetchAll(PDO::FETCH_ASSOC);

    // JSON data for the selected district
    $districtJsonData = json_encode($districtData);
?>
<!-- SECOND CHART -->


<?php
    $host = '139.144.179.217:3306'; // your host
    $db = 'rice_db'; // your database
    $user = 'acgds'; // your username
    $pass = 'C@pston3'; // your password

    $maxAttempts = 8; // maximum number of connection attempts
    $attempt = 0; // current attempt counter
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
    $tableName = "RiceCrop";
    $column1Name = "Season"; // Replace with the actual column name
    $column2Name = "RiceYield";

    // SQL query to fetch distinct districts
    $distinctDistrictsSQL = "SELECT District FROM (SELECT DISTINCT District FROM $tableName) AS tmp";
    $distinctDistrictsQuery = $pdo->prepare($distinctDistrictsSQL);
    $distinctDistrictsQuery->execute();
    $distinctDistricts = $distinctDistrictsQuery->fetchAll(PDO::FETCH_COLUMN);

    // Default selected district
    $selectedDistrict = isset($_GET['district']) ? $_GET['district'] : $distinctDistricts[0];

    // SQL query to fetch data for SA and WS seasons
    $saWsSQL = "SELECT $column1Name, YEAR($column1Name) AS year, AVG($column2Name) AS average_yield FROM $tableName WHERE $column1Name IN ('SA', 'WS') GROUP BY $column1Name, YEAR($column1Name) ORDER BY $column1Name ASC";
    $saWsQuery = $pdo->prepare($saWsSQL);
    $saWsQuery->execute();
    $saWsData = $saWsQuery->fetchAll(PDO::FETCH_ASSOC);

    // JSON data for SA and WS seasons
    $saWsJsonData = json_encode($saWsData);

    // SQL query to fetch data for the selected district
    $districtSQL = "SELECT $column1Name, YEAR($column1Name) AS year, AVG($column2Name) AS average_yield FROM $tableName WHERE District = ? GROUP BY $column1Name, YEAR($column1Name) ORDER BY $column1Name ASC";
    $districtQuery = $pdo->prepare($districtSQL);
    $districtQuery->execute([$selectedDistrict]);
    $districtData = $districtQuery->fetchAll(PDO::FETCH_ASSOC);

    // JSON data for the selected district
    $districtJsonData = json_encode($districtData);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rice Yield Over Seasons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chart-container1 {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <main role="main" class="container">
        <!-- Dashboard Section -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Rice Yield Over Seasons</h1>
        </div>

        <!-- Chart Section -->
        <div class="chart-container1">
            <canvas class="my-4 border border-dark" id="yieldChart1" width="900" height="380"></canvas>
        </div>

        <!-- Graph Info Section -->
        <div class="graph-info bg-light p-4 rounded">
            <h3>Rice Yield Over Seasons</h3>
            <p class="mb-0">This graph represents the average rice yield for all districts, as well as the SA (Summer/Autumn) and WS (Winter/Spring) seasons. The Y-axis represents yield in tons per hectare. It shows the variations in rice yield for different years across all districts.</p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // JSON data for SA and WS seasons
        var saWsJsonData1 = <?php echo $saWsJsonData; ?>;

        // JSON data for the selected district
        var districtJsonData1 = <?php echo $districtJsonData; ?>;

        // Extract data for SA and WS seasons
        var saWsSeasons1 = [];
        var saWsYields1 = [];

        saWsJsonData1.forEach(function(entry) {
            var season = entry.<?php echo $column1Name; ?>;
            var year = entry.year;
            var seasonYear = season + ' ' + year;
            saWsSeasons1.push(seasonYear);
            saWsYields1.push(entry.average_yield);
        });

        // Define the chart for SA and WS seasons
        var ctx1 = document.getElementById('yieldChart1').getContext('2d');
        var saWsChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: saWsSeasons1,
                datasets: [{
                    label: 'SA & WS Seasons',
                    data: saWsYields1,
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

