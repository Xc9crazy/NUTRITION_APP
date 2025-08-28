<?php
$host = 'db';
$user = 'appuser';
$pass = 'apppass';
$db   = 'nutrition_app';

$conn = new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$conn->set_charset("utf8mb4");
date_default_timezone_set('Asia/Tokyo');

$user_result = $conn->query("SELECT id, username FROM users");
if($user_result->num_rows > 0){
    while($user = $user_result->fetch_assoc()){
        echo "<h2>ユーザー: ".htmlspecialchars($user['username'])."</h2>";

        $stmt = $conn->prepare("
            SELECT ml.eaten_at AS logged_at, ml.meal_type, ml.quantity, f.name AS food_name,
                   f.calories, f.protein, f.fat, f.carb AS carbohydrate, f.fiber
            FROM meal_logs ml
            JOIN foods f ON ml.food_id = f.id
            WHERE ml.user_id = ?
            ORDER BY ml.eaten_at ASC
        ");
        $stmt->bind_param("i",$user['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        $totalCalories=0; $totalProtein=0; $totalFat=0; $totalCarbs=0; $totalFiber=0;

        echo "<table border='1' cellpadding='5'>
                <tr>
                    <th>日付</th><th>食事タイプ</th><th>食品名</th><th>量(g)</th><th>カロリー(kcal)</th>
                    <th>タンパク質(g)</th><th>脂質(g)</th><th>炭水化物(g)</th><th>食物繊維(g)</th>
                </tr>";

        while($row=$result->fetch_assoc()){
            $qty = $row['quantity'];
            $calories=$row['calories']*$qty/100;
            $protein=$row['protein']*$qty/100;
            $fat=$row['fat']*$qty/100;
            $carbs=$row['carbohydrate']*$qty/100;
            $fiber=$row['fiber']*$qty/100;

            $totalCalories+=$calories;
            $totalProtein+=$protein;
            $totalFat+=$fat;
            $totalCarbs+=$carbs;
            $totalFiber+=$fiber;

            echo "<tr>
                    <td>{$row['logged_at']}</td>
                    <td>{$row['meal_type']}</td>
                    <td>".htmlspecialchars($row['food_name'])."</td>
                    <td>{$qty}</td>
                    <td>".round($calories,1)."</td>
                    <td>".round($protein,1)."</td>
                    <td>".round($fat,1)."</td>
                    <td>".round($carbs,1)."</td>
                    <td>".round($fiber,1)."</td>
                  </tr>";
        }

        echo "<tr>
                <td colspan='3'><strong>合計</strong></td>
                <td></td>
                <td><strong>".round($totalCalories,1)."</strong></td>
                <td><strong>".round($totalProtein,1)."</strong></td>
                <td><strong>".round($totalFat,1)."</strong></td>
                <td><strong>".round($totalCarbs,1)."</strong></td>
                <td><strong>".round($totalFiber,1)."</strong></td>
              </tr>";
        echo "</table><br><br>";
        $stmt->close();
    }
}else{
    echo "ユーザーが存在しません。";
}
$conn->close();
?>
