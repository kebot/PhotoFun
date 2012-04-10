<?php require_once('common.php');
if( ! $current_user ){
  die("Please login to upload a photo.");
}

function get_file_extension($file_name)
{
  $extend =explode(".", $file_name);
  $va=count($extend)-1;
  return $extend[$va];
}


//$available_file_type = ['image/jpeg', 'image/png', 'image/bmp', 'image/*'];

if( $_FILES['file']['error'] > 0 ){
  $data['error'] = "Error" . $_FILES['file']['error'];
} else {
  $keys = array('title', 'description');
  foreach($keys as $key){
    if(array_key_exists($key, $_POST)){
      $$key = trim($_POST[$key]);
    } else {
      $$key = false;
    }
  }

  if($title){
    $store = new Lists();
    $id = $store->last()->get('id');
    if( $id < 0 ){
      $id = 0;
    } else {
      $id = $id + 1;
    }
    $filename = "" . $id . '.' . get_file_extension($_FILES['file']['name']);
    $newname = BASEPATH . '/static/submissions/' . $filename;
    move_uploaded_file($_FILES['file']['tmp_name'], $newname);
    $store->add($id, $filename, $title, $description);
    header("Location: /index.php?id=$id");
  } else {
    $data['error'] = 'Please input the title.';
  }
}

if( !array_key_exists( 'status', $_GET )){
  $data['error'] = false;
}

print $twig->render('upload.html', $data);
