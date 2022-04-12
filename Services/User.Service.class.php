<?php

class UserService extends Model
{

  public static function getUserID(string $tablename, array $identifiers)
  {
      if(array_keys($identifiers)[0] == "tutorID")
      {
        $eID = self::get($tablename, $identifiers)["employeeID"];
        return self::get("employees", ["employeeID"=>$eID])["userID"];
      }
      else
      {
        $data = self::get($tablename, $identifiers); 
        return $data[0]["userID"];
      }
  }

  public static function setUser(
    string $type, 
    string $email, 
    string $password, 
    int $status, 
    string $personalData, 
    string $metaData)
    {
      return self::set("users", 
      [
        "type"=>$type, 
        "email"=>$email, 
        "password"=>password_hash($password, PASSWORD_DEFAULT), 
        "status"=>$status, 
        "personalData"=>$personalData, 
        "metaData"=>$metaData
      ]);
    }

  public static function setUserType(string $type, array $identifiers, string $tablename)
  {
    $table = $type == "STUDENT" ? "students" : "employees";

    echo $uID = self::getUserID($tablename, $identifiers);

    return self::set($table, ["userID"=>$uID]);
  }

  public static function getUser(array $identifiers = [])
  {
    return self::get("users", $identifiers);
  }

  public static function updateUser(array $identifiers, array $data)
  {
    return self::update("users", $identifiers, $data);
  }

  public static function deleteUser(array $identifiers = [])
  {
    return self::del("users", $identifiers);
  }

  public static function setEmployeeType(string $type, array $identifiers, string $tablename)
  {
    switch ($type) {
      case 'TUTOR':
        $table = "tutors";
        break;
      default:
        return false;
        break;
    }

    $eID = self::get($tablename, $identifiers)["employeeID"];

    return self::set($table, ["employeeID"=>$eID]);
  }
}

?>