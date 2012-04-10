<?php require_once('common.php');
$keys = array('username', 'password', 'redirect');

foreach($keys as $key){
  if(array_key_exists($key, $_POST)){
    $$key = trim($_POST[$key]);
  } else {
    $$key = false;
  }
}

if($username and $password){
  $result = $user->login($username, $password);
  if(! $result){
    $data['error'] = 'Wrong Password or Username!';
  } else {
    $redirect or $redirect = '/index.php';
    header("Location: $redirect");
    exit();
  }
}

print $twig->render('login.html', $data);
