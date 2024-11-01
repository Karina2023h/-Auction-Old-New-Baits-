<?php
// Підключення до бази даних
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Запит для додавання нового користувача
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "Реєстрація успішна! Можете ввійти.";
    } else {
        echo "Помилка: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
