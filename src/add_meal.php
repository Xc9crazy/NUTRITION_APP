<?php
$servername = "db";   // docker-compose.yml の service 名
$username   = "appuser";
$password   = "rootpass";
$dbname     = "nutrition_app";

// DB接続
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = 1; // 今回は仮にユーザーID=1の食事ログを表示

$sql = "
    SELECT 
        f.name,
        ml.serving_size,
        (f.calories * ml.serving_size / 100) AS total_calories,
        (f.protein * ml.serving_size / 100)  AS total_protein,
        (f.fat * ml.serving_size / 100)      AS total_fat,
        (f.carbs * ml.serving_size / 100)    AS total_carbs,
        (f.fiber * ml.serving_size / 100)    AS total_fiber
    FROM meal_logs ml
    JOIN foods f ON ml.food_id = f.id
    WHERE ml.user_id = ?
    ORDER BY ml.eaten_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$totalCalories = $totalProtein = $totalFat = $totalCarbs = $totalFiber = 0;

echo "<h2>今日の食事ログ</h2>";
echo "<table border='1' cellpadding='5'>
<tr>
  <th>食べたもの</th>
  <th>量 (g)</th>
  <th>カロリー (kcal)</th>
  <th>タンパク質 (g)</th>
  <th>脂質 (g)</th>
  <th>炭水化物 (g)</th>
  <th>食物繊維 (g)</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['serving_size']}</td>
            <td>{$row['total_calories']}</td>
            <td>{$row['total_protein']}</td>
            <td>{$row['total_fat']}</td>
            <td>{$row['total_carbs']}</td>
            <td>{$row['total_fiber']}</td>
          </tr>";

    $totalCalories += $row['total_calories'];
    $totalProtein  += $row['total_protein'];
    $totalFat      += $row['total_fat'];
    $totalCarbs    += $row['total_carbs'];
    $totalFiber    += $row['total_fiber'];
}
echo "</table>";

echo "<h3>合計</h3>";
echo "総カロリー: {$totalCalories} kcal<br>";
echo "タンパク質: {$totalProtein} g<br>";
echo "脂質: {$totalFat} g<br>";
echo "炭水化物: {$totalCarbs} g<br>";
echo "食物繊維: {$totalFiber} g<br>";

$conn->close();
?>