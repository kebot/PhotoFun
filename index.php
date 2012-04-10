<?php require_once('common.php');
  // random image
  $id = array_key_exists('id', $_GET) ? $_GET['id'] : 1;
  $list = new Lists();

  $data['current'] = $list->find('id', $id)->get_array();
  $data['next'] = $list->get_next();
  $data['previous'] = $list->get_previous();

  $c = new Comments($id);
  $data['comments'] = $c->get_all();

  print $twig->render('index.html',$data);
?>
