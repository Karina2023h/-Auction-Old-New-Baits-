<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Вам необхідно увійти, щоб зробити покупку!";
    exit;
}

$lot_id = $_GET['lot_id'];
$user_id = $_SESSION['user_id'];

// Отримуємо інформацію про лот
$stmt = $conn->prepare("SELECT * FROM lots WHERE lot_id = ?");
$stmt->bind_param("i", $lot_id);
$stmt->execute();
$lot = $stmt->get_result()->fetch_assoc();

if (isset($_POST['buy_now'])) {
    if ($lot['blitz_price'] > 0) {
        // Оновлення статусу лота та зв'язок покупця з продавцем
        $stmt = $conn->prepare("UPDATE lots SET current_price = ?, status = 'sold', buyer_id = ? WHERE lot_id = ?");
        $stmt->bind_param("dii", $lot['blitz_price'], $user_id, $lot_id);
        $stmt->execute();
        echo "Ви успішно придбали лот за бліц-ціною!";
    }
}
?>
