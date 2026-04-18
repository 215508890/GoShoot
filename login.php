<?php
header('Content-Type: application/json');
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
$player_number = $data['player_number'];
$password = $data['password'];

$stmt = $pdo->prepare("SELECT * FROM players WHERE player_number = ?");
$stmt->execute([$player_number]);
$user = $stmt->fetch();
if ($user && password_verify($password, $user['password_hash'])) {
  $_SESSION['user_id'] = $user['id'];
  echo json_encode(['success' => true, 'user' => $user]);
} else {
  echo json_encode(['success' => false, 'message' => 'ID或密碼錯誤']);
}
?>
