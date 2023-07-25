<!doctype html>
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
<!-- Carousel -->
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="imgs/crop1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <div class="carousel-caption-bg bg-dark">
                       	<h3>Team-Project</h3>
                        <h5>-Ektor Avlonitis</h5>
                        <h5>-Alex Vavakas</h5>
                        <h5>-Spyros Kalogeris</h5>
                        <h5>-Pavlos Gaitanis</h5>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="imgs/crop2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <div class="carousel-caption-bg bg-dark">
                        <h4>Capstone Project: EY Level-2</h4>
                        <h5>Rice Yield Forecasting​</h5>

                    </div>
                </div>
            </div>
            <!-- Add more carousel items here -->
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
		</a>
		</div>

<br>
         <!-- Text box -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-box">
                    <h2>Predicting Rice Yields with Data Science</h2>
                    <p>Welcome to our project on forecasting rice yield 
                        using the cutting-edge technologies of data science, 
                        machine learning, and satellite imagery. 
                        With climate change posing significant challenges to food security 
                        globally, our mission is to predict rice yields accurately in Vietnam, 
                        a region greatly affected by these changes. Explore our journey through data,
                        science, and prediction, as we strive to contribute to solutions that ensure food security for all.
                    </p>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Cards -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="imgs/crop1.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Understanding the Challenge</h5>
                        <p class="card-text">Dive into the heart of our project - understanding the problem we aim to solve. Discover why forecasting rice yield is of vital importance and how Vietnam plays a crucial role in this challenge. </p>
                        <a href="https://challenge.ey.com/challenges/level-2-crop-forecasting-qEk17wFWyq" target="_blank" class="btn btn-info">EY Challenge</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
	<div class="card">
	<img src="imgs/crop2.jpg" class="card-img-top" alt="...">
	<div class="card-body">
	<h5 class="card-title"> Our Approach</h5>
	<p class="card-text">Here, you can explore the methodologies we're using to predict rice yield. From analyzing satellite images to weather data, we're employing the power of data science to create an accurate forecasting model. Learn more about the tools, techniques, and software we're using in this project.</p>
	<!-- <a href="#" class="btn btn-info">Go somewhere</a> -->
	</div>
	</div>
	</div>
	<div class="col-md-4">
	    <div class="card">
	    <img src="imgs/crop3.jpg" class="card-img-top" alt="...">
	        <div class="card-body">
	        <h5 class="card-title">Findings and Conclusions</h5>
	        <p class="card-text">Some quick example text to build on 
            the card title and make up the bulk of the card's content.</p>
	        <a href="graphs.php" class="btn btn-info">Conclusions</a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
    <br>
</body>
</html>
