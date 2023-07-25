<!doctype html>
<html>
<head>
    <?php include 'templates/header.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Side Menu Styles */
        .side-menu {
            width: 200px;
            background-color: rgba(104, 159, 56, 0.8);
            padding: 0; /* Updated */
            height: calc(100vh - 64px);
            position: sticky;
            top: 64px;
            left: 0;
        }

        .side-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .side-menu li {
            margin-bottom: 10px;
        }

        .side-menu a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 5px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .side-menu a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Chart Container Styles */
        #chartContainer {
            margin-left: 0; /* Updated */
            margin-right: 20px; /* Added */
            padding: 20px;
        }

        /* Remove left margin from body element */
        body {
            margin-left: 0;
        }

        /* Responsive Styles */
        @media (max-width: 576px) {
            .side-menu {
                width: 100%;
                position: static;
                background-color: rgba(104, 159, 56, 0.8);
                height: auto;
            }

            .side-menu ul {
                padding-left: 20px;
            }

            .side-menu a {
                color: #fff;
            }

            #chartContainer {
                margin-left: 0;
                margin-right: 0;
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include 'templates/navbar.php'; ?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3">
                <!-- Side Menu -->
                <div class="side-menu">
                    <ul>
                        <li><a href="#" data-chart="RYoverTime.php">EY Data</a></li>
                        <li><a href="#" data-chart="rvi.php">Sentinel_1 RVI</a></li>
                        <li><a href="#" data-chart="model_fatures.php">Model</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <!-- Chart Container -->
                <div id="chartContainer"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Load the first chart by default
            loadChart('RYoverTime.php');

            // Handle menu item clicks
            $('.side-menu a').click(function(e) {
                e.preventDefault();

                // Get the chart URL from the data attribute
                var chartURL = $(this).data('chart');

                // Load the chart content dynamically
                loadChart(chartURL);
            });

            // Function to load the chart content
            function loadChart(chartURL) {
                $.ajax({
                    url: chartURL,
                    success: function(data) {
                        $('#chartContainer').html(data);
                    }
                });
            }
        });
    </script>
</body>
</html>
