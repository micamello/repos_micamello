<?php
class Database{
  //abstract out mysql constants
  const ASSOC = MYSQLI_ASSOC;
  const NUM = MYSQLI_NUM;
  const BOTH = MYSQLI_BOTH;
  
  var $server;
  var $username;
  var $password;

  var $dbname;

  var $connection;
  var $query;
  var $resultSet;
  
  protected $lastQuery;
  protected $trimEnabled = true;
  protected $result;
  private $queries = array(); 
  private $res_set;    
  private $rowset = array(); 
  private $total_queries; 
  private $_trans_status; 

  function __construct( $server, $user, $pass, $dbname = false ){
    $this->server   = $server;
    $this->username = $user;
    $this->password = $pass;
    $this->dbname = $dbname;
  }

  function connect(){
    $this->connection = mysqli_connect($this->server, $this->username, $this->password) or die("No se pudo conectar a la base de datos");
    if ( $this->connection ){   
      return $this->selectDB();   
    }
    else{
      return false;
    }
  }

  function selectDB(){  
  if ( $this->dbname ){
    return mysqli_select_db($this->connection,$this->dbname)or die("No se pudo conectar a la Base de Datos");
  }
  else{
    return false;
  } 
  }

  function disconnect(){
    mysqli_close($this->connection);
  }

  function execute( $query ){
    $this->query = $query;    
    Utils::log("SQL execute: $query");
	  $resultSet = mysqli_query( $this->connection,$query );
	  $this->resultSet = $resultSet;
	  return $resultSet;
  }
  
  function insert( $table, $data ){   
    $i = 1;
    $col_list = '';
    $val_list = '';
    foreach ( $data as $col => $value ){
      if ( $i != 1 ){
        $col_list .= ',';
        $val_list .= ',';
      }
      //$value = mysql_real_escape_string($value);
      $col_list .= $col;            
      $val_list .= "'".$value."'";
      $i++;
    }
    $query  = 'INSERT INTO ';
    $query .= $table;
    $query .= ' (';
    $query .= $col_list;
    $query .= ') VALUES (';
    $query .= $val_list;
    $query .= ')';
    return $this->execute( $query );
  }

  function insert_multiple($table,$campos,$data){   

    $valores = '';
    foreach ($data as $key => $datos) {
      $valores = '('.implode(',', $datos).'),';
    }
    $valores = substr($valores, 0,strlen($valores)-1);

    $query  = 'INSERT INTO ';
    $query .= $table;
    $query .= ' (';
    $query .= $campos;
    $query .= ') VALUES';
    $query .= $valores;
    $query .= ';';
    return $this->execute( $query );
  }

  function update( $table, $data, $where ){        
    $query  = "UPDATE ";
    $query .= $table;
    $query .= " SET ";
    $i = 1;
    foreach ( $data as $col => $value ){
      if ( $i != 1 ) {
        $query .= ",";
      }
      $query .= $col . '="' . $value . '"';
      $i++;
    }
    $query .= " WHERE ";
    $where = $where;
    $query .= $where;
    return $this->execute( $query );    
  }

  function rows_affected(){
    return mysqli_affected_rows($this->connection);
  }

  function delete( $table, $where ){
    $query  = 'DELETE FROM ';
    $query .= $table;
    $query .= ' WHERE ';
    $where = $where;
    $query .= $where;
    return $this->execute( $query );
  }

  function getLastError(){    
   return mysqli_error($this->connection);
  }
  
  function fetch_row($result_set, $dorowset=false, $result_type=self::ASSOC ) {
    if( !$dorowset ) {
      if ($result_set === FALSE) {
        return $result_set;
      }
      return mysqli_fetch_array($result_set, $result_type);
    }
    if( $dorowset ) {      
      $result = array();
      if ($result_set === FALSE) {
        return $result;
      }
      while( $rows = mysqli_fetch_array( $result_set, $result_type ) ){
        $result[] = $rows;
      }
      return $result;
    }
  }
  
  public function formatQuery($sql, $params=array()){
    if (count($params)==0){
      return $sql;
    }
    $parts = explode('?', $sql);
    $n = count($parts);
    if( $n == 0 ){
      return $sql;
    }
    $i = 1;
    $result = '';
    foreach ($params as $param){
      if ($i >= $n ){
        break;
      }
      $result .= $parts[$i-1] . "'" . $param . "'";
      $i++;
    }
    $result.= $parts[$n-1];
    return $result;
  }
  
  function Query($query, $params=array()) {
    if (count($params)>0){
      $query = $this->formatQuery($query, $params);
    }
    Utils::log("SQL Query: $query");
    $this->result = mysqli_query($this->connection, $query);
    $this->total_queries++;
    if ($this->result === FALSE){
      //$msg = "SQL ERROR: ". $this->error();
      //Utils::log($msg);
    }
    $this->_trans_status = false;      
    $this->lastQuery = $query;
    $this->_trans_status = true;
    return $this->result;
  }
  
  function auto_array($query, $params = array(), $dorowset=false, $result_type=self::ASSOC) {
    $this->result = $this->Query($query, $params);
    if($this->result === false){
      return null;
    }
    $this->res_set = $this->fetch_row($this->result, $dorowset, $result_type);
    return $this->res_set;
  }
  
  function error() {
    return mysqli_connect_errno($this->connection). ': ' .  mysqli_connect_error($this->connection);
  }
  
  function close(){
    $this->disconnect(false);
  }
  
  function beginTrans() {
    Utils::log("SQL Trans: START TRANSACTION");
    return mysqli_begin_transaction($this->connection);
  }
  
  function commit(){    
    Utils::log("SQL Trans: COMMIT");   
    return mysqli_commit($this->connection);   
  }
  
  function rollback(){
    Utils::log("SQL Trans: ROLLBACK");     
    return mysqli_rollback($this->connection);;     
  }
  
  function insert_id(){
    return mysqli_insert_id($this->connection);
  }
  
}


?>