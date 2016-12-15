<?php
// Connexion à la BDD
try {
  $instance = new PDO("mysql:host=localhost;dbname=chat", "root", "", array(
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ));
} catch (Exception $e) {
  die($e->getMessage());
}

// On récupère les données envoyé par le Front en AJAX
$credentials = array(
  "pseudo" => $_POST['pseudo'],
  "password" => $_POST['password'],
);

// On récup l'utilisateur en BDD
$userQuery = $instance->prepare("SELECT *
  FROM user
  WHERE user.pseudo = :pseudo"
);
$userQuery->execute(array("pseudo" => $credentials['pseudo']));
$user = $userQuery->fetch();
// Si un utilisateur avec ce pseudo existe
if ($user) {
  // On test le mot de passe.
  if ($user['password'] === $credentials['password']) {
    // Si le mdp est bon je connecte l'utilisateur
    $userConnected = true;
  } else {
    // Le mdp n'est pas bon, je ne connecte pas l'utilisateur
    $userConnected = false;
  }
} else { // Si je n'ai pas d'utilisateur avec ce pseudo, je l'ajoute.
  $insertUserQuery = $instance->prepare('INSERT INTO user (pseudo, password)
  VALUES (:pseudo, :password)');
  $newUser = $insertUserQuery->execute(array(
    'pseudo' => $credentials['pseudo'],
    'password' => $credentials['password']
  ));
  // Une fois créé, je connecte l'utilisateur.
  $userConnected = true;
}

// Je renvois la réponse en JSON au front.
header('Content-Type: application/json'); // j'indique que ma réponse contient du JSON (et non du HTML).
// Je formate une réponse en JSON
echo json_encode(array("success" => $userConnected, "user" => $user));










// header('Content-Type: application/json');
// echo json_encode($datas);
