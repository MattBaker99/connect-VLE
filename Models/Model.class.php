<?php 
class Model extends Database
{
  protected static function set(string $tablename, array $data)
  {
    $pStmt = self::generatePreparedStatement("SET", $tablename, $data);
    return self::query($pStmt["sql"], $pStmt["values"]);
  }

  protected static function get(string $tablename, array $identifiers = [])
  {
    $pStmt = self::generatePreparedStatement("GET", $tablename, $identifiers);
    return self::query($pStmt["sql"], $pStmt["values"]);
  }

  protected static function update(string $tablename, array $identifiers, array $data)
  {
    $pStmt = self::generatePreparedStatement("UPDATE", $tablename, $identifiers, $data);
    return self::query($pStmt["sql"], $pStmt["values"]);
    // print_r($pStmt);
  }

  protected static function del(string $tablename, array $identifiers = [])
  {
    $pStmt = self::generatePreparedStatement("DELETE", $tablename, $identifiers);
    return self::query($pStmt["sql"], $pStmt["values"]);
    // print_r($pStmt);
  }

  // Generates an SQL string based on operation
  // Returns SQL and Values to replace prepared statement "slots"
  private static function generatePreparedStatement(string $method, string $tablename, array $identifiers = [], array $data = [])
  {
    switch ($method) {
      case 'GET':
        $sql = "SELECT * FROM " . $tablename;
        if ($identifiers)
        {
          $preparedWhere = self::generatePreparedSection($identifiers);

          return ["sql" => $sql . " WHERE " . $preparedWhere["sql"] . ";" , "values" => $preparedWhere["values"]];
        }
        else
        {
          return ["sql" => $sql . ";" , "values" => []];
        } 
        break;
      case 'SET':
        $sql = "INSERT INTO " . $tablename;
        $columns = "";
        $blank_vals = "";
        $vals = array();

        foreach($identifiers as $key=>$value)
        {
          $columns .= $key . ", ";
          $blank_vals .= "?, ";
          $vals[] = $value;
        }
        $columns = substr($columns, 0, -2);
        $blank_vals = substr($blank_vals, 0, -2);
        return ["sql"=> $sql . " ($columns) VALUES ($blank_vals);", "values"=>$vals];
        break;
      case 'UPDATE':
        $sql = "UPDATE " . $tablename . " SET ";
        $preparedSet = self::generatePreparedSection($data);
        $preparedWhere = self::generatePreparedSection($identifiers);

        return ["sql"=> $sql . $preparedSet["sql"] . " WHERE " . $preparedWhere["sql"] . ";" , "values"=>array_merge($preparedSet["values"], $preparedWhere["values"])];
        break;
      case 'DELETE':
        $sql = "DELETE FROM " . $tablename;
        if ($identifiers)
        {
          $preparedWhere = self::generatePreparedSection($identifiers);

          return ["sql"=>$sql . " WHERE " . $preparedWhere["sql"] . ";" , "values"=>$preparedWhere["values"]];
        }
        else
        {
          return ["sql" => $sql . ";" , "values" => NULL];
        }
        break;
      default:
        return false;
        break;
    }
  }

  // Generate a prepared string and seperates the replacement values
  // $data should be in the form ["columnName"=>Value, ...]
  // Prepared string is in the form of : "$key = ?, ..."
  // Returns String and Values for that prepared String.
  private static function generatePreparedSection(array $data)
  {
    $temp = "";
    $temp_array = array();
    foreach($data as $key=>$value)
    {
      $temp .= $key . "= ?, ";
      $temp_array[] = $value;
    }

    $temp = substr($temp, 0, -2);

    return ["sql" => $temp, "values" => $temp_array];
  }
}
?>