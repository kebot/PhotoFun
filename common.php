<?php
  define('DEBUG', true);
  define('BASEPATH', dirname(__FILE__));
  define('STORAGE_FOLDER', BASEPATH . '/data');
  define('VIEW_FOLDER', BASEPATH . '/views');
  require_once BASEPATH . '/libs/Twig/Autoloader.php';
  Twig_Autoloader::register();
  $loader = new Twig_Loader_Filesystem( BASEPATH . '/views' );
  $twig = new Twig_Environment($loader, array(
    'cache' => BASEPATH . '/cache',
    'debug' => DEBUG,
  ));
  require_once(BASEPATH . '/classes/users.php');
  $user = new Users();
  $current_user = $user->get_current_user($_COOKIE);
  $data = array(
    'current_user' => $current_user,
  );
