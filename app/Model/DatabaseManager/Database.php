<?php

namespace App\Model\DatabaseManager;

use PDO;
use PDOException;

class Database
{

  /**
   * Host de conexão com o banco de dados
   * @var string
   */
  private static $host;

  /**
   * Nome do banco de dados
   * @var string
   */
  private static $name;

  /**
   * Usuário do banco
   * @var string
   */
  private static $user;

  /**
   * Senha de acesso ao banco de dados
   * @var string
   */
  private static $pass;

  /**
   * Porta de acesso ao banco
   * @var integer
   */
  private static $port;

  /**
   * Nome da tabela a ser manipulada
   * @var string
   */
  private $table;

  /**
   * Nomes das tabelas a serem unidas
   * @var string
   */
  private $join;

  /**
   * Instancia de conexão com o banco de dados
   * @var PDO
   */
  private $connection;

  /**
   * Método responsável por configurar a classe
   * @param  string  $host
   * @param  string  $name
   * @param  string  $user
   * @param  string  $pass
   * @param  integer $port
   * @return void
   */
  public static function config($host,$name,$user,$pass,$port = 3306)
  {
    self::$host = $host;
    self::$name = $name;
    self::$user = $user;
    self::$pass = $pass;
    self::$port = $port;
  }

  /**
   * Define a tabela e instancia e conexão
   * @param string $table
   * @return void
   */
  public function __construct($table = null)
  {
    $this->table = $table;
    $this->setConnection();
  }

  /**
   * Método responsável por criar uma conexão com o banco de dados
   * @return void
   */
  private function setConnection()
  {
    try{
      $this->connection = new PDO('mysql:host='.self::$host.';dbname='.self::$name.';port='.self::$port,self::$user,self::$pass);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  /**
   * Método responsável por executar queries dentro do banco de dados
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  public function execute($query,$params = [])
  {
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  /**
   * Método responsável por inserir dados no banco
   * @param  array $values [ field => value ]
   * @return integer ID inserido
   */
  public function insert($values)
  {
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

    $this->execute($query,array_values($values));

    return $this->connection->lastInsertId();
  }

  /**
   * Método responsável por unir tabelas na consulta no banco
   * @param string $foreignTable
   * @param string $match
   * @param string $joinType
   * @return void
   */
  public function join($foreignTable, $match, $joinType = "INNER JOIN")
  {
    $this->join .= " {$joinType} {$foreignTable} ON {$match} ";
  }

  /**
   * Método responsável por executar uma consulta no banco
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return PDOStatement
   */
  public function select($where = null, $order = null, $limit = null, $fields = '*')
  {
    $where = strlen($where) ? 'WHERE '.$where : '';
    $order = strlen($order) ? 'ORDER BY '.$order : '';
    $limit = strlen($limit) ? 'LIMIT '.$limit : '';
    $join  = strlen($this->join) ? $join = $this->join : $join = '';

    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$join.' '.$where.' '.$order.' '.$limit;

    return $this->execute($query);
  }

  /**
   * Método responsável por executar atualizações no banco de dados
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update($where,$values)
  {
    $fields = array_keys($values);
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

    $this->execute($query,array_values($values));

    return true;
  }

  /**
   * Método responsável por excluir dados do banco
   * @param  string $where
   * @return boolean
   */
  public function delete($where)
  {
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    $this->execute($query);

    return true;
  }

}
