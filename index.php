<?php
include("./pdo.php");

$sql = '
SELECT
    schedule_title,
    schedule_start,
    schedule_end
FROM
    schedule
ORDER BY
    schedule_start
';
$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グループカレンダー</title>
    <!-- GoogleFont読み込み -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    <!-- CSS読み込み -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="main">
            <div class="schedule-input">
                <form action="./schedule_create.php" method="post">
                    <input type="text" name="schedule-title" id="schedule-title" placeholder="予定を入力" required>
                    <div class="schedule-date">
                        <input type="date" name="schedule-date-start" id="schedule-date-start" required>
                        <input type="time" name="schedule-time-start" id="schedule-time-start" required>
                        ～
                        <input type="time" name="schedule-time-end" id="schedule-time-end" required>
                    </div>
                    <!-- <input type="checkbox" name="schedule-type" id="schedule-type-my" checked><label
                        for="schedule-type-my">Myカレンダー</label>
                    <input type="checkbox" name="schedule-type" id="schedule-type-you" checked><label
                        for="schedule-type-you">Youカレンダー</label>　-->
                    <button>追加</button>
                </form>
            </div>
            <div class="calender">
                <div class="calender-month">
                    <button id="pre_month"><span class="material-symbols-outlined">
                            chevron_left
                        </span></button>
                    <span id="current-month"></span>
                    <button id="next_month"><span class="material-symbols-outlined">
                            chevron_right
                        </span></button>
                </div>
                <!-- <div class="calender-select">
                    <input type="checkbox" name="calender-type-my" id="calender-type-my"><label
                        for="calender-type-my">Myカレンダー</label>
                        <button>カレンダー追加</button>
                </div> -->
                <table class="calender-table" border="1">
                    <thead>
                        <tr>
                            <td>日</td>
                            <td>月</td>
                            <td>火</td>
                            <td>水</td>
                            <td>木</td>
                            <td>金</td>
                            <td>土</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="side">
            <!-- <div class="login-area">
                <img src="./google.svg" alt="">
            </div> -->
            <div class="schedule">
                <div class="schedule-day">
                    <h3>1月9日</h3>
                    <p>特になし</p>
                </div>
                <hr>
                <div class="schedule-day">
                    <h3>1月9日</h3>
                    <p>特になし</p>
                </div>
                <hr>
                <div class="schedule-day">
                    <h3>1月9日</h3>
                    <p>特になし</p>
                </div>
                <hr>
                <div class="schedule-day">
                    <h3>1月9日</h3>
                    <p>特になし</p>
                </div>
                <hr>
                <div class="schedule-day">
                    <h3>1月9日</h3>
                    <p>特になし</p>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- JS読み込み -->
    <script src="main.js" id="script" data-param='<?= json_encode($result); ?>'></script>
</body>

</html>