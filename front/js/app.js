// On attends la fin de chargement de la page
$(document).ready(function() {
  // Quand le formulaire est envoyé
  $(".Login_Form").on('submit', function(e) {
    e.preventDefault(); // On stop l'envoi du formulaire
    var datas = $(this).serializeArray(); // On récup les données du formulaire et on les formates.
    var formatDatas = {};
    for(var i=0; i < datas.length; i++) {
      formatDatas[datas[i]['name']] = datas[i]['value'];
    }
    // On passe les données à notre fonction de connexion.
    login(formatDatas);
  })

  var login = function(credentials) {
    // On crer une nouvelle requête AJAX, qui va essayer de nous connecter.
    $.ajax({
      method: 'POST',
      url: "http://localhost/chat/back/login.php",
      data: credentials,
      success: function(response) {
        // Si l'utilisateur est connecté
        if (response.success) {
          // On affiche le chat.
          displayChat();
        } else {
          // On affiche un message d'erreure
          $('.Login_Alert')
          .append("<p>Pseudo ou mot de passe incorrect !</p>")
          .removeClass('hide');
        }
      }
    })
  }
  // Hide login form and display chat.
  var displayChat = function() {
    // on cache le formulaire
    $(".Login").addClass("hide");
    // On affiche le chat
    $('.Chat').removeClass('hide');
    // On afficje la liste des utilisateurs
    updateUserList();
    // On affiche la liste des messages
    updateMessages();
  }

  // Reset userList
  var updateUserList = function() {
    var $userList = $(".Chat_User");
    // On récup la liste des utiliateurs
    $.ajax({
      method: "GET",
      url: "http://localhost/chat/back/user.php",
      success: function(res) {
        // res contient la réponse du serveur.
        var users = res.users; // On récup la liste des users renvoyés par le serveur.
        for (var i = 0; i < users.length; i++) {
          // On ajoute chaque utilisateur à notre liste HTML.
          $userList.append('<li>' + users[i]['pseudo'] +"</li>");
        }
      }
    })
  }

  var updateMessages = function() {

  }

})
