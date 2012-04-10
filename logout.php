<?php require_once('common.php');
  $redirect = $_POST['redirect'] or $_GET['redirect'];

  foreach(array('username', 'hash') as $key){
    setcookie($key, '', time() - 9999);
  }

  if(! $redirect){
    $redirect = '/index.php';
  }

  header("Location: $redirect");
?>
