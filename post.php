<?php require_once('common.php');
  if( $current_user ){
    $keys = array('comment', 'id');
    foreach($keys as $key){
      if(array_key_exists($key, $_POST)){
        $$key = $_POST[$key];
      } else {
        $$key = false;
      }
    }
    if($comment and $id){
      $c = new Comments($id);
      $c->post($current_user, $comment);
    }
  }
header("Location: /index.php?id=$id");
