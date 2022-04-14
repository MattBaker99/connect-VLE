<?php 
class Model extends Database
{
  protected static function set(string $table, array $setData)
  {
    $colString = "";

    $valString = "";

    $values = array();

    foreach ($setData as $col => $value) 
    {
      $colString .= $col . ", ";

      $valString .= "?, ";

      $values[] = $value;
    }
    
    $colString = substr($colString, 0, -2);

    $valString = substr($valString, 0, -2);
    
    $sql = "INSERT INTO " . $table . " ($colString) VALUES ($valString);";

    return self::query($sql, $values);
  }

  protected static function get(string $table, string $whereCondition = "", array $whereValues = [])
  {
    $sql = "SELECT * FROM " . $table;
    if ($whereCondition)
    {
      $sql .= " WHERE " . $whereCondition;
    }

    return self::query($sql, $whereValues);
  }

  protected static function update(string $table, string $whereCondition, array $whereValues, array $setData)
  {
    $setString = "";

    $setValues = array();
    
    foreach ($setData as $col => $value) 
    {
      $setString .= $col . " = ?, ";

      $setValues[] = $value;
    }
    
    $setString = substr($setString, 0, -2);
    
    $sql = "UPDATE " . $table . " SET $setString";
    
    if ($whereCondition)
    {
      $sql .=  " WHERE $whereCondition";
    }

    $sql .= ";";

    return self::query($sql, array_merge($setValues, $whereValues));
  }

  protected static function delete(string $table, string $whereCondition = "", array $whereValues = [])
  {
    $sql = "DELETE FROM " . $table;

    if ($whereCondition)
    {
      $sql .= " WHERE " . $whereCondition;
    }

    $sql .= ";";

    self::query($sql, $whereValues);
  }
}
?>