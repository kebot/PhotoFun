<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once( BASEPATH .'/classes/storage.php');

/**
 * Users
 */
class Users extends FileStorage
{

  function __construct()
  {
    parent::__construct(BASEPATH . '/storage/users.txt', array(
      'name', 'password', 'email'
    ));
  }

  function login($username, $password)
  {
    $geted_password = $this->find('name', $username)->get('password');
    if($password){
      $passhash = $this->_password_hash($password);
      $this->is_login = $passhash == $geted_password;
      $this->is_login and $this->_set_current_user($username, $passhash);
    } else {
      $this->is_login = false;
    }
    return $this->is_login;
  }

  function _set_current_user($username, $passhash){
    setcookie('hash', sha1($passhash));
    setcookie('username', $username);
  }

  function signup($username, $password, $email){
    if($username and $password and $email){
      if($this->find('name', $username)->current >= 0){
        $this->error_message = "User alread exists!";
      } else {
        $this->append(array(
          $username,
          $this->_password_hash($password),
          $email
        ))->save();
        return true;
      }
    }
    return false;
  }

  function _password_hash($password){
    return md5(sha1($password));
  }

  function get_current_user($cookies){
    $names = array('username', 'hash');
    foreach($names as $name){
      if( array_key_exists($name, $cookies) ){
        $$name = $cookies[$name];
      } else {
        return false;
      }
    }
    if( $hash == sha1($this->find('name', $username)->get('password')) ){
      return $username;
    } else {
      return false;
    }
  }
}

class Lists extends FileStorage
{
  function __construct()
  {
    parent::__construct(BASEPATH . '/storage/list.txt', array(
      'id','filename', 'title', 'description'
    ));
  }

  function add($id, $filename, $title, $description ){
    if(!$description){
      $description = "Some Description";
    }
    $this->append( array($id, $filename, $title, $description)
      )->save();
  }
}

class Comments extends FileStorage
{
  function __construct($id)
  {
    parent::__construct(BASEPATH . "/storage/comments_$id.txt", array(
      'commenter', 'comment', 'date'
    ));
  }

  function post($commenter, $comment){
    $data = array($commenter, $comment, date("Y-m-d H:i"));
    $this->append($data)->save();
  }
}

?>
