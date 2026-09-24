<?php

require_once "config_database.php";

$name = "";
$student_id = "";
$email = "";
$password = "";

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

$existing = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {

    $sql = "UPDATE users
            SET student_id = ?, name = ?, password = ?
            WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $student_id,
        $name,
        $hashed_password,
        $email
    ]);

    echo "User account updated successfully!";

} else {

    $sql = "INSERT INTO users
            (student_id, name, email, password)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $student_id,
        $name,
        $email,
        $hashed_password
    ]);

    echo "User account created successfully!";
}

?>