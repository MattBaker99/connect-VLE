<?php

  class SubmissionService extends Model
  {
    private static $tableName = "submissions";

    public static function setSubmission(int $courseID, int $studentID, int $resourceID, string $type, string $title, string $filePath, array $metaData)
    {
      return self::set(self::$tableName, 
      [
        "courseID"=>$courseID,
        "studentID"=>$studentID,
        "resourceID"=>$resourceID,
        "type"=>$type,
        "title"=>$title,
        "filePath"=>$filePath,
        "metaData"=>json_encode($metaData)
      ]);
    }

    public static function getSubmission(string $where = "", array $whereVals = [])
    {
      return self::get(self::$tableName, $where, $whereVals);
    }

    public static function updateSubmission(string $where = "", array $whereVals = [], array $setData)
    {
      return self::update(self::$tableName, $where, $whereVals, $setData);
    }

    public static function deleteSubmission(string $where = "", array $whereVals = [])
    {
      return self::delete(self::$tableName, $where, $whereVals);
    }
  }
?>