<?php
// Підключення до бази даних
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Пошук користувача за електронною поштою
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            echo "Вхід успішний!";
        } else {
            echo "Неправильний пароль!";
        }
    } else {
        echo "Користувача з такою електронною поштою не знайдено!";
    }
    $stmt->close();
    $conn->close();
}
?>
