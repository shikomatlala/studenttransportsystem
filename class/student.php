<?php
include_once "../../../connect.php";
include_once "form.php";
class Student
{
  private $stud_number;
  private $first_name;
  private $last_name;
  private $id_nr;
  private $sex;
  private $phone;
  private $email;
  private $address;
  private $link;
  //Status Variables
  private $status_first_name;
  private $status_last_name;
  private $status_id_nr;
  private $status_sex;
  private $status_phone;
  private $status_address;
  public function set_stud_number()
  {
    $sql = "SELECT MAX(stud_number) AS max_value \n"
        . "FROM student";
    $result = mysqli_query($this->link, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
          //Show the hightest number
          $this->stud_number= (int)$row["max_value"];
          $this->stud_number++;
        }
    }
  }
  public function get_stud_number()
  {
    return $this->stud_number;
  }
  public function set_email($stud_number)
  {
    $this->email = $stud_number . "@tut4life.ac.za";

  }
  public function get_email()
  {
    return $this->email;
  }
  public function set_address($address)
  {
    if(strlen($address) > 5)
    {
        $this->address = $address;
    }
    else
    {
      $this->address = "NULL";
    }
  }
  public function get_address()
  {
    return $this->address;
  }
  public function set_link($link)
  {
    $this->link = $link;
  }
  public function get_link()
  {
    return $this->link;
  }
  public function get_stud_name_status($first_name)
  {
    $out = "";
    if($first_name =="NULL")
    {
      $out = "Invalid First Name";
      return $out;
    }
    else
    {
      $out = "Good";
      return $out;
    }
  }
  public function get_stud_surn_status($last_name)
  {
    $out = "";
    if($last_name =="NULL")
    {
      $out = "Invalid Last Name";
      return $out;
    }
    else
    {
      $out = "Good";
      return $out;
    }
  }
  public function get_id_status($id_nr)
  {
    $out = "";
    if($id_nr == "NULL")
    {
      $out = "Invalid ID Number";
      return $out;
    }
    else
    {
      $out = "Good";
      return $out;
    }
  }
  public function get_phone_status($validate_phone)
  {
      $out = "";
      if($validate_phone == 0)
      {
        $out = "Phone already taken / Invalid";
        return $out;
      }
      else
      {
        $out = "Good";
        return $out;
      }
  }
  public function set_student($stud_number, $first_name, $id_nr, $sex, $phone, $email, $address)
  {
    return "Hi";
  }
  public function check_id($id_nr, $link)
  {
     $out= 1;
     $sql = "SELECT * FROM student WHERE id_nr  = \"$id_nr\" ";

     $result = mysqli_query($link, $sql);
     if(mysqli_num_rows($result) > 0)
     {
       $out = 0;
     }
     return $out;
  }
  public function validate_name($string)
  {
    //check it is not num
    //find the size of th string -
    //Trim white space
    $string = trim($string, " ");
    $out = 0;
    if(ctype_alpha($string))
    {
      $out = 1;
    }
    return $out;
  }
  public function set_firstname($first_name)
  {
    $student = new Student();
    if($student->validate_name($first_name) ==1)
    {
      $this->first_name = $first_name;
    }
    else
    {
      $this->first_name = "NULL";
    }
  }
  public function get_firstname()
  {
    return $this->first_name;
  }
  public function set_lastname($last_name)
  {
    $student = new Student();
    if($student->Validate_name($last_name) == 1)
    {
      $this->last_name = $last_name;
    }
    else
    {
      $this->last_name = "NULL";
    }
  }
  public function set_sex($sex)
  {
    $this->sex = $sex;
  }
  public function get_sex()
  {
    return $this->sex;
  }
  public function get_lastname()
  {
    return $this->last_name;
  }
  public function validate_phone($phone,$link)
  {
    //"0723302232"
     $out= 0;
     $sql = "SELECT * FROM student WHERE phone= \"$phone\" ";
     $result = mysqli_query($link, $sql);
     if(ctype_digit($phone) && strlen($phone) == 10)
     {
       if(substr($phone,0,1) == "0")
       {
         if( (int)$phone >0)
         {
          if(mysqli_num_rows($result) == 0)
          {
            $out =1;
          }
         }
       }
     }
     return $out;
  }
  public function set_phone($phone, $link)
  {
    $student = new Student();
    if($student->validate_phone($phone, $link) == 1)
    {
      $this->phone = $phone;
    }
    else
    {
      $this->phone = "NULL";
    }
  }
  public function get_phone()
  {
    return $this->phone;
  }
  public function validate_id($id_nr)
  {
    //Check the size
    $out = 0;
    $id_nr = trim($id_nr," ");
    $int_id = (int)$id_nr;
    if($int_id > 0)
    {
      //9910230093082
      if(ctype_digit($id_nr) && strlen($id_nr) ==13)
      {
        if(substr($id_nr,2,2) != "00")
        {
          if(substr($id_nr,4,2)!="00")
          {
            $out =1;
          }
        }
      }
    }
    return $out;
  }
  public function set_id($id_nr, $link)
  {
    $student = new Student();
    if($student->validate_id($id_nr) == 1 && $student->check_id($id_nr, $link) == 1)
    {
      $this->id_nr = $id_nr;
    }
    else
    {
     $this->id_nr = "NULL";
    }
  }
  public function get_id()
  {
    return $this->id_nr;
  }
  public function get_student_label()
  {
      $label = new Label();
      $label_increment = "";
      $label->set_label("","Student Number: ". $this->stud_number, "");
      $label_increment .= "\n". $label->get_label() . "<br>";
      $label->set_label("", "ID Number: ".$this->id_nr, "");
      $label_increment .= "\n". $label->get_label() . "<br>";
      $label->set_label("", "First Name: ".$this->first_name, "");
      $label_increment .= "\n". $label->get_label() . "<br>";
      $label->set_label("","Last Name: ". $this->last_name, "");
      $label_increment .= "\n". $label->get_label() . "<br>";
      $label->set_label("","Sex: ". $this->sex, "");
      $label_increment .= "\n". $label->get_label() . "<br>";
      $label->set_label("", "Phone: ".$this->phone, "");
      $label_increment .= "\n". $label->get_label() . "<br>";
      $label->set_label("", "Email: ".$this->email, "");
      $label_increment .= "\n".  $label->get_label() . "<br>";
      $label->set_label("","Address: ". $this->address, "");
      $label_increment .= "\n". $label->get_label() . "<br>";
      return $label_increment;


  }
  public function validate_sex($id_nr, $sex)
  {
    $out ="Sex does not match your ID Number";
    $id_nr = substr($id_nr, 6, 4);
    if((int)$id_nr > 4999 && $sex =="M")
    {
      $out = "Good";
      return $out;
    }
    elseif((int)$id_nr < 5000 && $sex == "F")
    {
      $out = "Good";
      return $out;
    }
    else
    {
      return $out;
    }
  }
  public function view_sql()
  {
    //I think we need to validate the sex in here - 
    $sql = "INSERT INTO student  (`stud_number`, `first_name`, `last_name`, `id_nr`, `gender`, `phone`, `email`, `address`) VALUES\n"
        . "($this->stud_number, '$this->first_name', '$this->last_name', '$this->id_nr', '$this->sex', '$this->phone', '$this->email', \"$this->address\")";
    return $sql;
  }
}
