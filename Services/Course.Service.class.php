<?php

class CourseService extends Model 
{
  private static $tableName = "courses";

  public static function createCourse(array $setData)
  {
    return self::set(self::$tableName, $setData);
  }

  public static function updateCourse(string $whereCondition = "", array $whereValues = [], array $setData)
  {
    return self::update(self::$tableName, $whereCondition, $whereValues, $setData);
  }

  public static function getCourse(string $whereCondition = "", array $whereValues = [])
  {
    return self::get(self::$tableName, $whereCondition, $whereValues);
  }

  public static function deleteCourse(string $whereCondition = "", array $whereValues)
  {
    return self::delete(self::$tableName, $whereCondition, $whereValues);
  }
}
?>