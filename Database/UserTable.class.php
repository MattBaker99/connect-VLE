<?php
  class Users extends Database
  {
    private static $tableName = "Users";

    public static function setUser(array $data)
    {
      return self::query(
        "INSERT INTO " . self::$tableName . " (frname, srname, email, password, type) VALUES (?, ?, ?, ?, ?);", 
        [$data["frname"], $data["srname"], $data["email"], password_hash($data["password"], PASSWORD_DEFAULT), $data["type"]]
      );
    }

    public static function removeUser(string $id)
    {
      return self::query(
        "DELETE FROM " . self::$tableName. " WHERE userID=?;", 
        [$id]
      );
    }

    public static function getAllUsers()
    {
      return self::query("SELECT * FROM " . self::$tableName, []);
    }

    public static function getUserByType(string $type)
    {
      return self::query(
        "SELECT * FROM " . self::$tableName . " WHERE type=?;", 
        [$type]
      );
    }

    public static function getUserByID(string $id)
    {
      return self::query(
        "SELECT * FROM " . self::$tableName . " WHERE userID=?;", 
        [$id]);
    }
  }
?>