<?php 
class Model extends Database
{
  // NEEDS WORK ->> TESTING
  public static function set(array $data = null, string $tablename)
  {
    if ($data)
    {
      $columns = "";
      $temp = "";
      foreach ($data as $key => $value)
      {
        $columns .= $key . ", ";
        $temp .= "?, ";  
      }

      $columns = substr($columns, 0, -2);
      $temp = substr($temp, 0, -2);
    
      self::query("INSERT INTO " . $tablename . "($columns) VALUES ($temp);", $data);
    }
    else
    {
      return false;
    }
  }

  // DONE
  public static function get(array $identifiers = null, string $tablename)
  {
    if ($identifiers)
    {
      $tempData = self::formPreparedStatement($identifiers);
      return self::query("SELECT * FROM " . $tablename . " WHERE " . $tempData["sql"], $tempData["values"]);
    }
    else
    {
      $sql = "SELECT * FROM " . $tablename . ";";
      return self::query($sql, []);
    }
  }

  // NEEDS WORK ->> TESTING
  public static function update(array $identifiers = null, array $data, string $tablename)
  {
    // Identifiers can only be used in the "WHERE" section
    // Data can only be used in the "SET" section

    if($identifiers)
    {
      $whereData = self::formPreparedStatement($identifiers);
      $setData = self::formPreparedStatement($data);

      return self::query(
        "UPDATE " . $tablename . " SET " . $setData["sql"] . " WHERE " . $whereData["sql"] . ";",
        array_merge($setData["values"], $whereData["values"])
      );
      // Update $tablename SET column=? ... WHERE column=?;
    }
    else
    {
      return false;
    }
  }

  // DONE
  public static function del(array $identifiers = null, string $tablename)
  {
    if($identifiers)
    {
      $tempData = self::formPreparedStatement($identifiers);
      return self::query("DELETE FROM " . $tablename . " WHERE " . $tempData["sql"], $tempData["values"]);
    }
    else
    {
      // Commented out because scary : deletes all records
      // return self::query("DELETE FROM " . self::$tablename, []);
      return false;
    }
  }

  private static function formPreparedStatement(array $identifiers)
  {  
    // Creates $temp string for prepared statement to represent "column=?".
    $temp = "";
    foreach($identifiers as $key => $value)
    {
      $temp .= $key . "=?,";
    }

    // Trim end of string to remove extra "," and place ";" at end. Adds $temp string to end of $sql string.
    $temp = substr($temp, 0, -1);
    $temp .= ";";

    // Forms all indentifier values into array for prepared statement
    $values = array();
    foreach($identifiers as $value)
    {
      $values[] = $value;
    }

    return ["sql" => $temp, "values" => $values];
  }
}
?>