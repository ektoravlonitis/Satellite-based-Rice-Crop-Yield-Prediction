// <!-- Chart 1 code -->
// JSON data 
include 'db.php';
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
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
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
