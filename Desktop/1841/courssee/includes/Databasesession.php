<?php

function login($pdo, $email, $password) {
    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();
    if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        return ['success' => 'Login successful! Welcome back, ' . $user['username'], 'user' => $user];
    } else {
        return ['error' => 'Invalid email or password!'];
    }
}

function register($pdo, $username, $email, $password, $role = 'user') {
    if (empty($username) || empty($email) || empty($password)) {
        return ['error' => 'Please fill in all fields!'];
    }
    // Check for duplicate emails
    $sqlEmail = 'SELECT * FROM users WHERE email = :email';
    $stmtEmail = $pdo->prepare($sqlEmail);
    $stmtEmail->execute([':email' => $email]);
    if ($stmtEmail->fetch()) {
        return ['error' => 'Email already exists!'];
    }
    // Check for duplicate usernames
    $sqlUser = 'SELECT * FROM users WHERE username = :username';
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->execute([':username' => $username]);
    if ($stmtUser->fetch()) {
        return ['error' => 'Username already exists!'];
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sqlInsert = 'INSERT INTO users (username, email, password, role, created_at) VALUES (:username, :email, :password, :role, NOW())';
    $paramsInsert = [
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':role' => $role
    ];
    $stmtInsert = $pdo->prepare($sqlInsert);
    $success = $stmtInsert->execute($paramsInsert);
    if ($success) {
        return ['success' => 'Registration successful! You can now login.'];
    } else {
        return ['error' => 'Registration failed!'];
    }
}

function logout() {
    session_unset();
    session_destroy();
}
