<!DOCTYPE html>
<html>
<head>
    <?php
        include 'templates/header.php';
    ?>
    <style>
        /* Text Box index.php */
        .text-box {
            background-color: #f8f9fa;
            opacity: 0.93;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .text-box h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .text-box p {
            color: #555;
            font-size: 16px;
            line-height: 1.5;
        }

        .team-section {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .team-section h3 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .team-section ul {
            padding: 0;
        }

        .team-section li {
            list-style: none;
            margin-bottom: 10px;
        }

        .team-section li a {
            color: #333;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <?php
        include 'templates/navbar.php';
    ?>
    <!-- space -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <br>
            </div>
        </div>
    </div>

    <!-- Carousel -->
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <!-- Carousel items here -->
    </div>

    <!-- Text box -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-box">
                    <h2>Predicting Rice Yields with Data Science</h2>
                    <p>Welcome to our project on forecasting rice yield using the cutting-edge technologies of data science, machine learning, and satellite imagery. With climate change posing significant challenges to food security globally, our mission is to predict rice yields accurately in Vietnam, a region greatly affected by these changes. Explore our journey through data, science, and prediction, as we strive to contribute to solutions that ensure food security for all.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards -->
    <div class="container mt-5">
        <div class="row">
            <!-- Card items here -->
        </div>
    </div>

    <!-- Team section -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="team-section">
                    <h3>Team Members</h3>
                    <ul>
                        <li><a href="https://github.com/team-member-1" target="_blank">Team Member 1</a></li>
                        <li><a href="https://github.com/team-member-2" target="_blank">Team Member 2</a></li>
                        <li><a href="https://github.com/team-member-3" target="_blank">Team Member 3</a></li>
                        <li><a href="https://github.com/team-member-4" target="_blank">Team Member 4</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
