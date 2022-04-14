<?php
  class ResourceService extends Model
  {
    private static $tableName = "resources";

    public static function setResource(
      int $courseID, 
      int $tutorID, 
      string $type,
      string $title,
      string $filePath,
      array $metaData = []
      )
    {
      return self::set(self::$tableName, 
      [
        "courseID"=>$courseID,
        "tutorID"=>$tutorID, 
        "type"=>$type,
        "title"=>$title,
        "filePath"=>$filePath,
        "metaData"=>json_encode($metaData),
      ]);
    }

    public static function updateResource(string $whereCondition, array $whereVals, array $setData)
    {
      return self::update(self::$tableName, $whereCondition, $whereVals, $setData);
    }

    public static function getResource(string $where = "", array $whereVals = [])
    {
      return self::get(self::$tableName, $where, $whereVals);
    }

    public static function deleteResource(string $where = "", array $whereVals = [])
    {
      return self::delete(self::$tableName, $where, $whereVals);
    }
  }
?>