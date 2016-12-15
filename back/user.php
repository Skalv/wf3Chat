<?php
// Connexion à la BDD
try {
  $instance = new PDO("mysql:host=localhost;dbname=chat", "root", "", array(
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ));
} catch (Exception $e) {
  die($e->getMessage());
}

// Récup de la lsite des utilisateurs.
$userList = $instance->query('SELECT pseudo FROM user')->fetchAll();
// Je renvois la réponse en JSON au front.
header('Content-Type: application/json'); // j'indique que ma réponse contient du JSON (et non du HTML).
// Je formate une réponse en JSON
echo json_encode(array("success" => true, "users" => $userList));
