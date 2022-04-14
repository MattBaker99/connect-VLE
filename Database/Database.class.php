<?php
  class Database
  {
    public static $host = "localhost";
    public static $username = "root";
    public static $password = "root";
    public static $dbname = "connectVLE";
    
    protected static function query(string $sql, array $args = [])
    {
      try {
        $stmt = self::connect()->prepare($sql);
  
        if (explode(" ", $sql)[0] == "SELECT")
        {
          $stmt->execute($args);
          return $stmt->fetchAll();
        }
        else
        {
          return $stmt->execute($args);
        }
      } catch (PDOException $e) {
        echo($e->getMessage());
        echo("<br>");
        echo($sql);
        echo("<br>");
        print_r($args);
      }
    }
    
    protected static function connect()
    {
      $dsn = "mysql:host=" . Database::$host . ";dbname=" . Database::$dbname;
      $pdo = new PDO($dsn, Database::$username, Database::$password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    }
  }
?>