<?php

class CourseService extends Model 
{
  public static function getCourse(array $identifiers = [])
  {
    return self::get("courses", $identifiers);
  }

  public static function setCourse(
    string $courseTitle,
    string $subject,
    string $description,
    int $length,
    bool $status,
    int $year,
    $dateStart,
    $dateEnd,
    string $additionalMetaData
  )
  {
    return self::set("courses", 
    [
      "courseTitle" => $courseTitle,
      "subject" => $subject,
      "description" => $description,
      "length" => $length,
      "status" => (int) $status,
      "year" => $year,
      "dateStart" => $dateStart,
      "dateEnd" => $dateEnd,
      "additionalMetaData" => $additionalMetaData
    ]
  );
  }

  
}
?>