<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Вам необхідно увійти, щоб зробити ставку!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $lot_id = $_POST['lot_id'];
    $bid_amount = $_POST['bid_amount'];

    // Отримуємо поточну ціну та час завершення аукціону
    $stmt = $conn->prepare("SELECT current_price, end_time FROM lots WHERE lot_id = ?");
    $stmt->bind_param("i", $lot_id);
    $stmt->execute();
    $stmt->bind_result($current_price, $end_time);
    $stmt->fetch();
    $stmt->close();

    // Перевірка на мінімальну суму ставки
    if ($bid_amount > $current_price) {
        // Встановлюємо нову ставку
        $stmt = $conn->prepare("INSERT INTO bids (lot_id, user_id, bid_amount) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $lot_id, $user_id, $bid_amount);
        $stmt->execute();

        // Оновлюємо поточну ціну в таблиці лотів
        $stmt = $conn->prepare("UPDATE lots SET current_price = ? WHERE lot_id = ?");
        $stmt->bind_param("di", $bid_amount, $lot_id);
        $stmt->execute();

        // Функція антиснайпер: перевіряємо, чи залишилось менше 5 хвилин до кінця аукціону
        $current_time = time();
        $time_remaining = strtotime($end_time) - $current_time;

        if ($time_remaining <= 300) { // 300 секунд = 5 хвилин
            $new_end_time = date("Y-m-d H:i:s", strtotime($end_time) + 300); // Додаємо 5 хвилин
            $stmt = $conn->prepare("UPDATE lots SET end_time = ? WHERE lot_id = ?");
            $stmt->bind_param("si", $new_end_time, $lot_id);
            $stmt->execute();
            echo "Ставка успішно зроблена, аукціон продовжено на 5 хвилин!";
        } else {
            echo "Ставка успішно зроблена!";
        }
    } else {
        echo "Ставка має бути більшою за поточну ціну!";
    }
}
?>
