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
                <li><a href="k-drama-best.php">K-Drama Chart</a></li>
                <li><a href="k-pop-best.php">K-POP Chart</a></li>
            </ul>
        </nav>
        <main>
            <div id="article">
                <h2>K-Drama Chart</h2>
                <div class="chart-container">
                    <div class="chart-category">
                        <h3>Weekly Chart</h3>
                        <ul>
                            <li><a href="#weekly-best-drama" onclick="showChart('weekly-best-drama')">Best Drama</a></li>
                            <li><a href="#weekly-best-actor-male" onclick="showChart('weekly-best-actor-male')">Best Actor - male</a></li>
                            <li><a href="#weekly-best-actor-female" onclick="showChart('weekly-best-actor-female')">Best Actor - female</a></li>
                            <li><a href="#weekly-best-supporting-actor-male" onclick="showChart('weekly-best-supporting-actor-male')">Best Supporting Actor - male</a></li>
                            
                            <li><a href="#weekly-best-supporting-actor-female" onclick="showChart('weekly-best-supporting-actor-female')">Best Supporting Actor - female</a></li>

                            <li><a href="#weekly-best-ost" onclick="showChart('weekly-best-ost')">Best OST</a></li>
                        </ul>
                    </div>
                    
                    <div class="chart-category">
                        <h3>Monthly Chart</h3>
                        <ul>
                            <li><a href="#monthly-best-drama" onclick="showChart('monthly-best-drama')">Best Drama</a></li>
                            <li><a href="#monthly-best-actor-male" onclick="showChart('monthly-best-actor-male')">Best Actor - male</a></li>
                            <li><a href="#monthly-best-actor-female" onclick="showChart('monthly-best-actor-female')">Best Actor - female</a></li>
                            <li><a href="#monthly-best-supporting-actor-male" onclick="showChart('monthly-best-supporting-actor-male')">Best Supporting Actor - male</a></li>
                            <li><a href="#monthly-best-supporting-actor-female" onclick="showChart('monthly-best-supporting-actor-female')">Best Supporting Actor - female</a></li>

                            <li><a href="#monthly-best-ost" onclick="showChart('monthly-best-ost')">Best OST</a></li>
                        </ul>
                    </div>
                </div>

               <!-- Weekly Best Drama Chart -->
<div class="chart-details" id="weekly-best-drama">
    <h4>Best Drama - Weekly (Based on Weekly Search Volume)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // 비밀번호가 없는 경우 비워둡니다.
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Weekly Best Drama Chart SQL
    $sql = "SELECT 
                id,
                korean_name,
                english_name,
                (1000 - 50 * POW(ROW_NUMBER() OVER (ORDER BY weekly_search_volume DESC), 1.5)) + weekly_search_volume AS final_score
            FROM 
                drama_ranking
            WHERE 
                chart_inclusion = 1
            ORDER BY 
                final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>한글 이름</th>
                        <th>영어 이름</th>
                        <th>그림</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["korean_name"]) . "</td>
                    <td>" . htmlspecialchars($row["english_name"]) . "</td>
                    <td><img src='path_to_images/" . htmlspecialchars($row["id"]) . ".jpg' alt='" . htmlspecialchars($row["korean_name"]) . "' width='100'></td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
</div>

                
<!-- Monthly Best Drama Chart -->
<div class="chart-details" id="monthly-best-drama">
    <h4>Best Drama - Monthly (Based on Total Search Volume)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // 비밀번호가 없는 경우 비워둡니다.
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Monthly Best Drama Chart SQL
    $sql = "SELECT 
                id,
                korean_name,
                english_name,
                (7000 - 70 * POW(ROW_NUMBER() OVER (ORDER BY search_volume DESC), 1.5)) + search_volume AS final_score
            FROM 
                drama_ranking
            WHERE 
                chart_inclusion = 1
            ORDER BY 
                final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>한글 이름</th>
                        <th>영어 이름</th>
                        <th>그림</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["korean_name"]) . "</td>
                    <td>" . htmlspecialchars($row["english_name"]) . "</td>
                    <td><img src='path_to_images/" . htmlspecialchars($row["id"]) . ".jpg' alt='" . htmlspecialchars($row["korean_name"]) . "' width='100'></td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
</div>

<!-- Weekly Best Actor Male Chart -->
<div class="chart-details" id="weekly-best-actor-male">
    <h4>Best Actor - Male (Based on Weekly Final Score)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // 비밀번호가 없는 경우 비워둡니다.
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Weekly Best Actor Male Chart SQL
    $sql = "SELECT 
                actor_name,
                korean_name,
                weekly_final_score,
                id
            FROM 
                best_actor_male
            ORDER BY 
                weekly_final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>배우 이름</th>
                        <th>이미지</th>
                        <th>출연한 드라마</th>
                        <th>총 점수</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["actor_name"]) . "</td>
                    <td><img src='" . htmlspecialchars($row["actor_image_url"]) . "' alt='" . htmlspecialchars($row["actor_name"]) . "' width='100'></td>
                    <td>" . htmlspecialchars($row["korean_name"]) . "</td>
                    <td>" . number_format($row["weekly_final_score"]) . "</td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
</div>

<!-- Monthly Best Actor Male Chart -->
<div class="chart-details" id="monthly-best-actor-male">
    <h4>Best Actor - Male (Based on Monthly Final Score)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // 비밀번호가 없는 경우 비워둡니다.
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Monthly Best Actor Male Chart SQL
    $sql = "SELECT 
                actor_name,
                korean_name,
                monthly_final_score,
                id
            FROM 
                best_actor_male
            ORDER BY 
                monthly_final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>배우 이름</th>
                        <th>이미지</th>
                        <th>출연한 드라마</th>
                        <th>총 점수</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["actor_name"]) . "</td>
                    <td><img src='" . htmlspecialchars($row["actor_image_url"]) . "' alt='" . htmlspecialchars($row["actor_name"]) . "' width='100'></td>
                    <td>" . number_format($row["monthly_final_score"]) . "</td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
</div>

<!-- Weekly Best Actor Female Chart -->
<div class="chart-details" id="weekly-best-actor-female">
    <h4>Best Actor - Female (Based on Weekly Final Score)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // 비밀번호가 없는 경우 비워둡니다.
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Weekly Best Actor Female Chart SQL
    $sql = "SELECT 
                actor_name,
                korean_name,
                weekly_final_score,
                id
            FROM 
                best_actor_female
            ORDER BY 
                weekly_final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>배우 이름</th>
                        <th>이미지</th>
                        <th>출연한 드라마</th>
                        <th>총 점수</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["actor_name"]) . "</td>
                    <td><img src='" . htmlspecialchars($row["actor_image_url"]) . "' alt='" . htmlspecialchars($row["actor_name"]) . "' width='100'></td>
                    <td>" . htmlspecialchars($row["korean_name"]) . "</td>
                    <td>" . number_format($row["weekly_final_score"]) . "</td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
</div>


<!-- Monthly Best Actor Female Chart -->
<div class="chart-details" id="monthly-best-actor-female">
    <h4>Best Actor - Female (Based on Monthly Final Score)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // 비밀번호가 없는 경우 비워둡니다.
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Monthly Best Actor Female Chart SQL
    $sql = "SELECT 
                actor_name,
                korean_name,
                monthly_final_score,
                id
            FROM 
                best_actor_female
            ORDER BY 
                monthly_final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>배우 이름</th>
                        <th>이미지</th>
                        <th>출연한 드라마</th>
                        <th>총 점수</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["actor_name"]) . "</td>
                    <td><img src='" . htmlspecialchars($row["actor_image_url"]) . "' alt='" . htmlspecialchars($row["actor_name"]) . "' width='100'></td>
                    <td>" . htmlspecialchars($row["korean_name"]) . "</td>
                    <td>" . number_format($row["monthly_final_score"]) . "</td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
</div>

<!-- Weekly Best Subactor Male Chart -->
<div class="chart-details" id="weekly-best-supporting-actor-male">
    <h4>Best Subactor - Male (Based on Weekly Final Score)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // 비밀번호가 없는 경우 비워둡니다.
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Weekly Best Subactor Male Chart SQL
    $sql = "SELECT 
                actor_name,
                korean_name,
                weekly_final_score,
                id
            FROM 
                best_subactor_male
            ORDER BY 
                weekly_final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>배우 이름</th>
                        <th>이미지</th>
                        <th>출연한 드라마</th>
                        <th>총 점수</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["actor_name"]) . "</td>
                    <td><img src='" . htmlspecialchars($row["actor_image_url"]) . "' alt='" . htmlspecialchars($row["actor_name"]) . "' width='100'></td>
                    <td>" . htmlspecialchars($row["korean_name"]) . "</td>
                    <td>" . number_format($row["weekly_final_score"]) . "</td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
</div>

<!-- Monthly Best Subactor Male Chart -->
<div class="chart-details" id="monthly-best-supporting-actor-male">
    <h4>Best Subactor - Male (Based on monthly Final Score)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // 비밀번호가 없는 경우 비워둡니다.
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // monthly Best Subactor Male Chart SQL
    $sql = "SELECT 
                actor_name,
                korean_name,
                monthly_final_score,
                id
            FROM 
                best_subactor_male
            ORDER BY 
                monthly_final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>배우 이름</th>
                        <th>이미지</th>
                        <th>출연한 드라마</th>
                        <th>총 점수</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["actor_name"]) . "</td>
                    <td><img src='" . htmlspecialchars($row["actor_image_url"]) . "' alt='" . htmlspecialchars($row["actor_name"]) . "' width='100'></td>
                    <td>" . htmlspecialchars($row["korean_name"]) . "</td>
                    <td>" . number_format($row["monthly_final_score"]) . "</td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
</div>

<!-- Weekly Best Subactor Female Chart -->
<div class="chart-details" id="weekly-best-supporting-actor-female">
    <h4>Best Subactor - female (Based on Weekly Final Score)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // 비밀번호가 없는 경우 비워둡니다.
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Weekly Best Subactor female Chart SQL
    $sql = "SELECT 
                actor_name,
                korean_name,
                weekly_final_score,
                id
            FROM 
                best_subactor_female
            ORDER BY 
                weekly_final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>배우 이름</th>
                        <th>이미지</th>
                        <th>출연한 드라마</th>
                        <th>총 점수</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["actor_name"]) . "</td>
                    <td><img src='" . htmlspecialchars($row["actor_image_url"]) . "' alt='" . htmlspecialchars($row["actor_name"]) . "' width='100'></td>
                    <td>" . htmlspecialchars($row["korean_name"]) . "</td>
                    <td>" . number_format($row["weekly_final_score"]) . "</td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
</div>

<!-- Monthly Best Subactor Female Chart -->
<div class="chart-details" id="monthly-best-supporting-actor-female">
    <h4>Best Subactor - Female (Based on Monthly Final Score)</h4>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "drama_ranking";

    // MySQL 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Monthly Best Subactor Female Chart SQL
    $sql = "SELECT 
                actor_name,
                korean_name,
                monthly_final_score,
                id
            FROM 
                best_subactor_female
            ORDER BY 
                monthly_final_score DESC
            LIMIT 30";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>순위</th>
                        <th>배우 이름</th>
                        <th>이미지</th>
                        <th>출연한 드라마</th>
                        <th>총 점수</th>
                    </tr>
                </thead>
                <tbody>";
        
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rank . "</td>
                    <td>" . htmlspecialchars($row["actor_name"]) . "</td>
                    <td><img src='" . htmlspecialchars($row["actor_image_url"]) . "' alt='" . htmlspecialchars($row["actor_name"]) . "' width='100'></td>
                    <td>" . htmlspecialchars($row["korean_name"]) . "</td>
                    <td>" . number_format($row["monthly_final_score"]) . "</td>";
            $rank++;
        }
        echo "</tbody></table>";
    } else {
        echo "순위 데이터를 찾을 수 없습니다.";
    }

    $conn->close();
    ?>
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
