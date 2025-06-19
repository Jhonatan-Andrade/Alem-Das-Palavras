

<?php
$db = new PDO('sqlite:database.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
$tabelaExiste = $stmt->fetch();
if (!$tabelaExiste) {
    $db->exec("CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT
    )");
  
}
function readUsers($db) {
    $stmt = $db->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createUser($db, $username, $password) {
    
    $user = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user->execute([$username]);
    $userData = $user->fetch(PDO::FETCH_ASSOC);
    if($userData) {return false;}

    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
}



function changeUserName($db, $id, $username) {
    $user = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user->execute([$username]);
    $userData = $user->fetch(PDO::FETCH_ASSOC);
    if($userData) {return false;}

    $stmt = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
    return $stmt->execute([$username, $id]);
}

function deleteUser($db, $id) {
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}
function login($db, $username, $password) {
    $user = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user->execute([$username]);
    $userData = $user->fetch(PDO::FETCH_ASSOC);
    
    if ($userData && password_verify($password, $userData['password'])) {
        return $userData;
    }
    return false;
}
?>