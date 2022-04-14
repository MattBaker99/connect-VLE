<?php
  include_once "../Database/Database.class.php";
  include_once "../Models/Model.class.php";
  include_once "../Services/User.Service.class.php";
  include_once "../Services/Course.Service.class.php";

  session_start();

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
  }

  function test_user_signup()
  {
    if (UserService::signup($_POST))
    {
      echo("SIGNED UP");
    }
    else
    {
      echo("ERROR");
    }
  }

  function test_user_login()
  {
    if(UserService::login($_POST))
    {
      echo("LOGGEDIN");
      print_r($_SESSION);
    }
    else
    {
      echo("FAIL");
    }
  }

  function test_user_update()
  {
    if(UserService::updateUser("userID=?", [10], $_POST))
    {
      echo("UPDATED");
      print_r(UserService::getUser("userID=?", [10]));
    }
    else
    {
      echo("ERROR");
    }
  }

  function test_user_delete()
  {
    // NEED TO ALTER TABLE SO DELETE CAUSES A CASTCADE DELETE OF REFERENCES
    if (UserService::deleteUser("userID=?", [2]))
    {
      echo("DELETED");
    }
    else
    {
      echo("ERROR");
    }
  }

  function test_course_create()
  {
    if (CourseService::createCourse($_POST))
    {
      echo "COURSE HAS BEEN CREATED";
    }
    else
    {
      echo "ERROR";
    }
  }

  // print_r(CourseService::getCourse("subject=?", ["ENGLISH"]));

  function test_course_update()
  {
    return CourseService::updateCourse("courseID=?", [3], ["length"=>25]);
  }

  // echo test_course_update();

  function test_enroll_user()
  {
    UserService::enroll(2, 3);
  }

  function test_unenroll_user()
  {
    return UserService::unenroll(8, 1);
  }

  function test_setUserType()
  {
    echo UserService::setUserType("userID=?", [10]);
  }

  test_setUserType();
?>

<!-- <form action="" method="post">
  <h1>Login</h1>
  <input type="text" placeholder="Email" name="email">
  <input type="text" placeholder="Password" name="password">
  <button type="submit">Login</button>
</form> -->

<!-- <form action="" method="post">
  <h1>Signup</h1>
  <input type="text" placeholder="Email" name="email">
  <input type="text" placeholder="Password" name="password">
  <button type="submit">Signup</button>
</form> -->

<!-- <form action="" method="post">
  <h1>SetUserType</h1>
  <div>
    <label for="student">Student</label>
    <input type="radio" name="type" id="student" value="STUDENT">
  </div>
  <div>
    <label for="tutor">Tutor</label>
    <input type="radio" name="type" id="tutor" value="TUTOR">
  </div>
  <div>
    <label for="NULL">NULL</label>
    <input type="radio" name="type" id="NULL" value="NULL">
  </div>
  <button type="submit">Set Type</button>
</form> -->

<!-- <form action="" method="post">
  <h1>Course Creation</h1>
  <input type="text" placeholder="Course Title" name="courseTitle">
  <input type="text" placeholder="Course Subject" name="subject">
  <input type="text-area" placeholder="Description" name="description">
  <input type="text" placeholder="Course Length" name="length">
  <input type="text" placeholder="Course Status" name="status">
  <input type="text" placeholder="Course Year" name="year">
  <button type="submit">Create Course</button>
</form> -->