<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_role']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ADMIN';
}

function isProductor() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'PRODUCTOR';
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getUserProductorId() {
    return $_SESSION['productor_id'] ?? null;
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
