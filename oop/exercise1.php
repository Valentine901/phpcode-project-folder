<?php

// department construction
// department lecturers
// department courses

class Department
{
    public $name;
    public $courses = [];
    public $teachers = [];
    public $students = [];
    public $setError = "";
    public $setSuccess = "";

    public function __construct($name, $courses, $teachers, $students, $setError, $setSuccess)
    {
        $this->name = $name;
        $this->courses = $courses;
        $this->teachers = $teachers;
        $this->students = $students;
        $this->setError = $setError;
        $this->setSuccess = $setSuccess;
    }

    // students actions 
    public function add_student(Student $student)
    {

        if (in_array($student, $this->students)) {
            $this->setError = "Student already exists";
            return;
        } else {
            $this->students[] = $student;
            $this->setSuccess = "Student added to departmental list";
        }
    }

    public function remove_student(Student $student) {
        if (!in_array($student, $this -> students)) {
            $this -> setError = "Student you want to deleted did not exist";
        }else {
            foreach($this -> students as $key => $value) {
                unset($this -> students[$key]);
            }
            $this -> setSuccess = "Student deleted successfully";
        }
    }

    // teachers actions

    // course actions
}


class Student extends Department
{
    public $student_name;
    public $student_age;
    public $student_reg;
    public $student_courses = [];

    public function __construct($student_age, $student_name, $student_reg, $student_courses)
    {
        $this->student_name = $student_name;
        $this->student_age = $student_age;
        $this->student_reg = $student_reg;
        $this->student_courses = $student_courses;
    }

    public function get_student_details()
    {
        return
            "Student Name: " . $this->student_name . "<br>
            Student Age: " . $this->student_age . "<br> 
            Student Reg. No: " . $this->student_reg . "<br>
            Department: " . $this->name . "<br>";
    }
}

class Teacher extends Department
{
    public $teacher_name;
    public $course_incharge;
    public $contact;

    function __construct($teacher_name, $course_incharge, $contact)
    {
        $this->teacher_name = $teacher_name;
        $this->course_incharge = $course_incharge;
        $this->contact = $contact;
    }

    public function get_teacher_details()
    {
        return
            "Teacher Name: " . $this->teacher_name . "<br>
            Course Incharge: " . $this->course_incharge . "<br> 
            Teacher Contact: " . $this->contact . "<br>";
    }
}

class Course
{
    public $course_name;

    public function __construct($course_name)
    {
        $this->course_name = $course_name;
    }
}
