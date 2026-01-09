<?php
include("./pdo.php");

// var_dump($_POST);

$schedule_title = $_POST["schedule-title"];
$schedule_date_start = $_POST["schedule-date-start"];
$schedule_time_start = $_POST["schedule-time-start"];
$schedule_time_end = $_POST["schedule-time-end"];

$schedule_start = $schedule_date_start . ' ' . $schedule_time_start . ':00';
$schedule_end = $schedule_date_start . ' ' . $schedule_time_end   . ':00';

$sql = '
INSERT INTO schedule(
    schedule_id,
    schedule_title,
    schedule_start,
    schedule_end
)
VALUES (
    NULL,
    :schedule_title,
    :schedule_start,
    :schedule_end
)';
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':schedule_title', $schedule_title);
$stmt->bindValue(':schedule_start', $schedule_start);
$stmt->bindValue(':schedule_end', $schedule_end);

try {
    $status = $stmt->execute();
    header("Location:index.php");
    exit();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}
