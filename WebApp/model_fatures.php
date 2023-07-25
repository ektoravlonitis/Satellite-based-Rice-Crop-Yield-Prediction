<?php
    // Database connection details
    $host = '139.144.179.217';
    $db = 'rice_db';
    $user = 'acgds';
    $pass = 'C@pston3';

    // Establish a database connection
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch data from the table
        $query = "SELECT * FROM model_features";
        $stmt = $pdo->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare data for the chart
        $features = array_column($data, 'Feature');
        $importanceRF = array_column($data, 'Importance_RF');
        $importanceET = array_column($data, 'Importance_ET');

        // Sort data arrays based on importance (from bigger to lower)
        array_multisort($importanceRF, SORT_DESC, $importanceET, SORT_DESC, $features);

        // Get the top 10 values
        $topFeatures = array_slice($features, 0, 10);
        $topImportanceRF = array_slice($importanceRF, 0, 10);
        $topImportanceET = array_slice($importanceET, 0, 10);

        // Truncate feature names to a maximum of 20 characters
        $truncatedFeatures = array_map(function($feature) {
            return strlen($feature) > 20 ? substr($feature, 0, 17) . '...' : $feature;
        }, $topFeatures);

        // Generate JSON data for the chart
        $jsonData = json_encode([
            'labels' => $truncatedFeatures,
            'datasets' => [
                [
                    'label' => 'Importance_RF',
                    'data' => $topImportanceRF,
                    'backgroundColor' => 'rgba(104, 159, 56, 0.5)',
                    'borderColor' => 'rgba(68, 127, 39, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Importance_ET',
                    'data' => $topImportanceET,
                    'backgroundColor' => 'rgba(31, 119, 180, 0.5)',
                    'borderColor' => 'rgba(23, 86, 131, 1)',
                    'borderWidth' => 1
                ]
            ]
        ]);

    } catch (PDOException $e) {
        echo "Failed to connect to the database: " . $e->getMessage();
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Feature Importance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <main role="main" class="container">
        <!-- Dashboard Section -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Feature Importance</h1>
        </div>

        <!-- Chart Section -->
        <div class="chart-container1">
            <canvas class="my-4 border border-dark" id="importanceChart" width="900" height="380"></canvas>
        </div>

        <!-- Graph Info Section -->
        <div class="graph-info bg-light p-4 rounded">
            <h3>Feature Importance</h3>
            <p class="mb-0">The chart illustrates the top 10 features and their importance in two models: Extra Trees and Random Forests. The bar heights represent the significance of each feature in predicting the target variable. By comparing the bar lengths between the two models, we can gain insights into the relative importance of these features in each model's decision-making process.</p>
        </div>
    </main>

    <script>
        // JSON data for the chart
        var chartData = <?php echo $jsonData; ?>;

        // Create the chart
        var ctx = document.getElementById('importanceChart').getContext('2d');
        var importanceChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)' // Color of the grid lines
                        },
                        ticks: {
                            fontColor: 'rgba(0, 0, 0, 0.9)' // Color of the tick labels
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
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
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>

</html>
