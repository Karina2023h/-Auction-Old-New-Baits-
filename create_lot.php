<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Вам необхідно увійти, щоб створити лот!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_price = $_POST['start_price'];
    $blitz_price = $_POST['blitz_price']; // Нова змінна для бліц-ціни
    $end_time = $_POST['end_time'];

    $stmt = $conn->prepare("INSERT INTO lots (user_id, category_id, title, description, start_price, current_price, blitz_price, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissddds", $user_id, $category_id, $title, $description, $start_price, $start_price, $blitz_price, $end_time);

    if ($stmt->execute()) {
        echo "Лот успішно створено!";
    } else {
        echo "Помилка: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
