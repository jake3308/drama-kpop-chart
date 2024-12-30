<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <title>K-Drama Chart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .chart-details {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h1><a href="index.php" class="main-title">SI Charts</a></h1>
    </header>
    <div id="content">
        <nav>
            <ul>
                <li><a href="#" onclick="showChart('weekly-best-drama')">Best Drama - Weekly</a></li>
                <li><a href="#" onclick="showChart('weekly-best-actor-male')">Best Actor - male</a></li>
                <li><a href="#" onclick="showChart('weekly-best-actor-female')">Best Actor - female</a></li>
                <li><a href="#" onclick="showChart('weekly-best-supporting-actor-male')">Best Supporting Actor - male</a></li>
                <li><a href="#" onclick="showChart('weekly-best-supporting-actor-female')">Best Supporting Actor - female</a></li>
                <li><a href="#" onclick="showChart('weekly-rising-star-male')">Rising Star - male</a></li>
                <li><a href="#" onclick="showChart('weekly-rising-star-female')">Rising Star - female</a></li>
                <li><a href="#" onclick="showChart('weekly-best-couple')">Best Couple</a></li>
                <li><a href="#" onclick="showChart('weekly-best-ost')">Best OST</a></li>
                <!-- Monthly Charts -->
                <li><a href="#" onclick="showChart('monthly-best-drama')">Best Drama - Monthly</a></li>
                <li><a href="#" onclick="showChart('monthly-best-actor-male')">Best Actor - male (Monthly)</a></li>
                <li><a href="#" onclick="showChart('monthly-best-actor-female')">Best Actor - female (Monthly)</a></li>
                <li><a href="#" onclick="showChart('monthly-best-supporting-actor-male')">Best Supporting Actor - male (Monthly)</a></li>
                <li><a href="#" onclick="showChart('monthly-best-supporting-actor-female')">Best Supporting Actor - female (Monthly)</a></li>
                <li><a href="#" onclick="showChart('monthly-rising-star-male')">Rising Star - male (Monthly)</a></li>
            </ul>
        </nav>
        <main>
            <div id="article">
                <h2>K-Drama Chart</h2>
                <div class="chart-container">
                    <!-- Weekly Best Drama Chart -->
                    <div class="chart-details" id="weekly-best-drama">
                        <h4>Best Drama - Weekly</h4>
                        <!-- Weekly Best Drama PHP Code -->
                    </div>

                    <!-- Monthly Best Drama Chart -->
                    <div class="chart-details" id="monthly-best-drama">
                        <h4>Best Drama - Monthly</h4>
                        <!-- Monthly Best Drama PHP Code -->
                    </div>

                    <!-- Additional Charts Here -->
                    <!-- Example for another chart -->
                    <div class="chart-details" id="weekly-best-actor-male">
                        <h4>Best Actor - male (Weekly)</h4>
                        <!-- Weekly Best Actor Male PHP Code -->
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 SI Charts</p>
    </footer>

    <script>
        function showChart(chartId) {
            var charts = document.getElementsByClassName('chart-details');
            for (var i = 0; i < charts.length; i++) {
                charts[i].style.display = 'none';
            }
            document.getElementById(chartId).style.display = 'block';
        }
    </script>
</body>
</html>
