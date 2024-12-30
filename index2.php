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

// 주간, 월간, 분기, 연간 기간을 처리하는 필터 추가 필요 (현재 기본 전체 데이터 사용)
$sql = "SELECT d.name, 
               (vd.viewership_score * 0.4 + 
               (bd.fundex_score * 0.3 + bd.imdb_score * 0.15 + bd.flixpatrol_score * 0.15) * 0.6) AS total_score
        FROM dramas d
        JOIN viewership_data vd ON d.id = vd.drama_id
        JOIN buzz_data bd ON d.id = bd.drama_id
        ORDER BY total_score DESC
        LIMIT 30";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Rank</th>
                <th>Drama Name</th>
                <th>Total Score</th>
            </tr>";
    
    $rank = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $rank . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . number_format($row["total_score"], 2) . "</td>
              </tr>";
        $rank++;
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
