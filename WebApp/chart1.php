<?php
    $host = '139.144.179.217:3306'; // your host
    $db = 'test'; // your database
    $user = 'acgds'; // your username
    $pass = 'C@pston3'; // your password

    // PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

    // SQL query
    $sql = "SELECT date, sales FROM table1 ORDER BY date ASC";
    $query = $pdo->prepare($sql);
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    // We'll encode this data in JSON format for use with Chart.js
    $jsonData = json_encode($data);
?>

<link href="style.css" rel="stylesheet">
<!-- Page Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10  pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0 ">
        <div class="btn-group mr-2">
        <button class="btn btn-sm btn-outline-secondary">Share</button>
        <button class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle ">
        <span data-feather="calendar"></span>
        This week
        </button>
    </div>
    </div>

    <canvas class="my-4 border border-dark" id="salesChart" width="900" height="380"></canvas>

    <h2>Section title</h2>
    <div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>#</th>
            <th>Header</th>
            <th>Header</th>
            <th>Header</th>
            <th>Header</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1,001</td>
            <td>Lorem</td>
            <td>ipsum</td>
            <td>dolor</td>
            <td>sit</td>
        </tr>
        <
        </tr>
        </tbody>
    </table>
    </div>
</main>



<script>
    // <!-- Chart 1 code -->
// JSON data 
var jsonData = <?php echo $jsonData; ?>;

// Extract dates and sales data from the JSON
var dates = jsonData.map(function(entry) {
    return entry.date;
});
var sales = jsonData.map(function(entry) {
    return entry.sales;
});
// print dates and sales data
console.log(dates);
console.log(sales);
var ctx = document.getElementById('salesChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: dates,
        datasets: [{
            label: 'Sales',
            data: sales,
            // Set the background color to a semi-transparent light green
            backgroundColor: 'rgba(104, 159, 56, 0.5)',
            // Set the border color to a darker green
            borderColor: 'rgba(68, 127, 39, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>

