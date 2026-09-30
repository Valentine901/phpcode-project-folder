<?php

// department construction
// department lecturers
// department courses

class Department
{
    public string $class;
    public string $name;
    public array $courses = [];
    public array $teachers = [];
    public array $students = [];
    public string $setError = "";
    public string $setSuccess = "";

    public function __construct($name)
    {
        $this->name = $name;
        $this->courses = [];
        $this->teachers = [];
        $this->students = [];
        $this->setError = "";
        $this->setSuccess = "";
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

    // neeed to update this code
    public function remove_student(Student $student) {
        if (!in_array($student, $this -> students)) {
            $this -> setError = "Student you want to deleted does not exist";
        }else {

            unset($this -> students[$student]);
            $this -> setSuccess = "Student deleted successfully";
        }
    }

    // need to update this code
    public function update_student(Student $student) {
        if (!in_array($student, $this -> students)) {
            $this -> setError = "Student you want to update does not exist";
        } else {
            $this -> students[] = $student;       
        }
    }
    // teachers actions

    // course actions
}


class Student extends Department
{
    public string $student_name;
    public int $student_age;
    public string $student_reg;
    public array $student_courses = [];

    public function __construct($student_age, $student_name, $student_reg)
    {
        $this->student_name = $student_name;
        $this->student_age = $student_age;
        $this->student_reg = $student_reg;
        $this->student_courses = [];
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



$computer_science = new Department("Computer Science");
$stud1 = new Student(27, "valentine", "STU-1002");
$stud2 = new Student(18, "Chadwick", "STU-2004");
$stud3 = new Student(19, "Edward", "STU-1003");

$computer_science -> add_student($stud1);
$computer_science -> add_student($stud2);

$computer_science -> update_student($stud3);

foreach($computer_science -> students as $student) {
    echo $student -> get_student_details() . "<br>";
}


?>