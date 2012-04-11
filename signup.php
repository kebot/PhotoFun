<?php require_once('common.php');
  $data = array();
  $keys = array('username', 'password', 'password2', 'email', 'school', 'twitter', 'login');
  foreach($keys as $key){
    if(array_key_exists($key, $_POST)){
      $$key = $_POST[$key];
    } else {
      $$key = false;
    }
  }

  if($username and $password and $email){
    if($password == $password2){
      if($user->signup($username, $password, $email, $school, $twitter)){
        if(! $redirect){
          $redirect = '/index.php';
        }
        if($login){
          $user->login($username, $password);
        }
        header("Location: $redirect");
      } else {
        $data['error'] = $user->error_message;
      }
    } else {
      $data['error'] = "Two password not the same";
    }
  }

  print $twig->render('signup.html', $data);
?>
