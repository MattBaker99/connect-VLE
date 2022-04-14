<?php

class UserService extends Model
{
  private static $tableName = "users";

  public static function getUser(string $where = "", array $whereValues = [])
  {
    return self::get(self::$tableName, $where, $whereValues);
  }

  public static function updateUser(string $where, array $whereValues, array $setData)
  {
    return self::update(self::$tableName, $where, $whereValues, $setData);
  }
  
  public static function deleteUser(string $where = "", array $whereValues = [])
  {
    return self::delete(self::$tableName, $where, $whereValues);
  }

  public static function signup(array $formData)
  {
    $results = self::getUser("email=?", [$formData["email"]]);

    if (isset($results[0]))
    {
      return false;
    }
    else
    {
      $formData["password"] = password_hash($formData["password"], PASSWORD_DEFAULT);
      return self::set(self::$tableName, $formData);
    }
  }

  public static function login(array $formData)
  {
    $results = self::getUser("email=?", [$formData["email"]]);

    if(isset($results[0]))
    {
      if(password_verify($formData["password"], $results[0]["password"]))
      {
        $_SESSION["USER_EMAIL"] = $results[0]["email"];
        $_SESSION["USER_TYPE"] = $results[0]["type"];
        $_SESSION["USER_ID"] = $results[0]["userID"];
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

  public static function enroll(int $userID, int $courseID, string $status = "", string $metaData = "")
  {
    $userData = self::getUser("userID=?", [$userID]);

    $type = $userData[0]["type"];

    return self::set("enrollments", ["courseID"=>$courseID, "userID"=>$userID, "status"=>$status, "type"=>$type, "metaData"=>$metaData]);
  }

  public static function unenroll(int $userID, int $courseID)
  {
    return self::delete("enrollments", "userID=? AND courseID=?", [$userID, $courseID]);
  }

  public static function setUserType(string $where, array $whereVals, array $optionalData = [])
  {
    $userData = self::getUser($where, $whereVals);

    if (!isset($userData[0]) || !isset($userData[0]["type"]))
    {
      return false;
    }

    switch ($userData[0]["type"]) {
      case 'STUDENT':
        return self::set("students", ["userID"=>$userData[0]["userID"]]);
        break;
      case 'EMPLOYEE':
        return self::set("employees", ["userID"=>$userData[0]["userID"], json_encode($optionalData)]);
        break;
      default:
        return false;
        break;
    }
  }
}

?>