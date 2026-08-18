<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=tryout", "root", "");
    $pdo->exec("ALTER TABLE user_exams MODIFY id_user VARCHAR(255)");
    echo "Done";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
