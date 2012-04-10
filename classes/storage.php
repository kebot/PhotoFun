<?php # if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  /**
   * Base Storage Class
   */
  class FileStorage{
    public $data = array(
      //array('yaofur', 'password', 'i@yaofur.com'),
      //array('kebot', 'password', 'kebot@yaofur.com'),
    );
    public $names = array('name', 'password', 'email');

    public $current = 0;

    public $filename = '';

    # init the FileStorage Class
    function __construct($filename, $names=false)
    {
      if($names){
        $this->names = $names;
      }
      if(file_exists($filename)){
        $handle = fopen( $filename, 'r' );
        while(!feof($handle)){
          $line = fgets($handle, 4096);
          $arr = explode('|', $line);
          if( count($arr) == count($this->names) ){
            array_push($this->data, $arr);
          }
        }
        fclose($handle);
      } else {
        $this->data = array();
      }
      $this->filename = $filename;
    }

    function last(){
      $this->current = $this->length() - 1;
      return $this;
    }

    function find($key, $value)
    {
      $this->current = -1;
      $pos = array_search($key, $this->names);
      if ($pos + 1 ) {
        foreach($this->data as $key => $row){
          if( $row[$pos] == $value ){
            $this->current = $key;
            return $this;
          }
        }
      }
      return $this;
    }

    function get($key){
      if($this->current+1 > 0){
        $order = array_search($key, $this->names);
        return $this->data[$this->current][$order];
      }
    }

    # get all for current pointed storage
    function get_array(){
      $result = array();
      if($this->current+1 and $this->current < $this->length()){
        foreach($this->names as $name){
          $result[$name] = $this->get($name);
        }
        return $result;
      }
      return false;
    }

    function index( $i ){
      $this->current = $i;
      return $this->get_array();
    }

    function get_next(){
      $this->current = $this->current + 1;
      $next = $this->get_array();
      $this->current = $this->current - 1;
      return $next;
    }

    function get_previous(){
      $this->current = $this->current - 1;
      $next = $this->get_array();
      $this->current = $this->current + 1;
      return $next;
    }



    function get_all(){
      $results = array();
      foreach($this->data as $array){
        $pairs = array();
        $counter = 0;
        foreach($array as $value){
          $name = $this->names[$counter];
          $pairs[$name] = $value;
          $counter ++;
        }
        array_push($results, $pairs );
      }
      return $results;
    }

    function length(){
      return count($this->data);
    }

    # insert a set of values into data array.
    /*
    function insert($input, $offset=false)
    {
      $count = count($this->data);
      if($offset>0 and $offset < count($this->data)){
        array_splice($this->data, $offset, );
      }
      #array_splice();
    }
     */

    function append($input)
    {
      array_push($this->data, $input);
      return $this;
    }

    # update `table` set $key = $value
    function update($key, $value)
    {
      if($this->current+1){
        $order = array_search($key, $this->names);
        $this->data[$this->current][$order] = $value;
      }
      return $this;
    }

    # insert the data to the file
    function save()
    {
      $handle = fopen($this->filename, 'w+');
      $towrite = "";


      foreach($this->data as $row){
        $tail = implode('|', $row);
        //print substr($tail, -1) != "\n"; exit();
        if(substr($tail, -1) != "\n"){
          $tail = $tail . "\n";
        }

        $towrite = $towrite . $tail;
      }
      fwrite($handle, $towrite);
      fclose($handle);
    }
  }

// test code here, will be comments.
/*
  $a = new FileStorage('../storage/admin.txt');
  $a->find('name', 'Keith')
    ->update('email','fuck@zjut.com')->get('email');
  print $a->save();
*/

?>
