<?php
// Connexion à la BDD
try {
  $instance = new PDO("mysql:host=localhost;dbname=chat", "root", "", array(
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ));
} catch (Exception $e) {
  die($e->getMessage());
}

// Si $_POST n'est pas vide, cela veut dire que l'on envois des données =>
// on ajoute un message
// sinon on veut récup la liste des messages.
if (!empty($_POST)) {
  // on ajoute le message à la BDD
  $insertQuery = $instance->prepare('INSERT INTO message (content, userId)
  VALUES (:content, :userId)');
  $insertQuery->execute(array(
    "content" => $_POST['content'],
    "userId" => $_POST['userId']
  ));
  // On retourne un success
  header('Content-Type: application/json'); // j'indique que ma réponse contient du JSON (et non du HTML).
  // Je formate une réponse en JSON
  echo json_encode(array("success" => true));

} else {
  // Récup de la lsite des utilisateurs.
  $messageList = $instance->query('SELECT * FROM message')->fetchAll();
  // Je renvois la réponse en JSON au front.
  header('Content-Type: application/json'); // j'indique que ma réponse contient du JSON (et non du HTML).
  // Je formate une réponse en JSON
  echo json_encode(array("success" => true, "messages" => $messageList));
}
