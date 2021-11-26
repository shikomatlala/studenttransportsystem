<?php
include_once "../config/connect.php";
include_once "form.php";
class User
{

  private $userId;
  private $fname;
  private $lname;
  private $idNumber;
  private $userType;
  private $phone;
  private $email;
  private $cAddress;
  private $password;
  private $link;
  //Status Variables
  private $status_first_name;
  private $status_last_name;
  private $status_id_nr;
  private $status_phone;
  private $status_address;

  public function setUser($userId, $fname, $lname, $userType)
  {
    $this->userId = $userId;
    $this->fname = $fname;
    $this->lname = $lname;
    $this->userType = $userType;
  }

  public function getUserType()
  {
    return $this->userType;
  }
  public function getUserId()
  {
    return $this->userId;
  }

  public function getUserFName()
  {
    return $this->fname;
  }

  public function getUserLName()
  {
    return $this->lname;
  }
  public function setPassword($password)
  {
      $this->password = $password;
  }
  public function getPassword()
  {
      return $this->password;
  } 
  public function setEmail($email)
  {
   
    $sql = "SELECT * FROM `user` WHERE email  = \"$email\" ";
    $result = mysqli_query($this->link, $sql);
    if(mysqli_num_rows($result) > 0)
    {
      $this->email = "NULL";
    }
    else
    {
      $this->email = $email;
    }
    //check if the email already exists first

  }
  public function getEmail()
  {
    return $this->email;
  }
  public function emailStatus()
  {
    if($this->getEmail()!="NULL")
    {
      return "Good";
    }
    else
    {
      return "Email already in use";
    }
  }
  public function setAddress($address)
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
  public function getAddress()
  {
    return $this->address;
  }
  public function setLink($link)
  {
    $this->link = $link;
  }
  public function getLink()
  {
    return $this->link;
  }
  public function getUserNameStatus($first_name)
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
  public function getUserSurnStatus($last_name)
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
  public function getIdStatus($idNumber)
  {
    $out = "";
    if($idNumber == "NULL")
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
  public function getPhoneStatus($validate_phone)
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
  public function checkIdNumber($idNumber, $link)
  {
     $out= 1;
     $sql = "SELECT * FROM `user` WHERE idNumber  = \"$idNumber\" ";

     $result = mysqli_query($link, $sql);
     if(mysqli_num_rows($result) > 0)
     {
       $out = 0;
     }
     return $out;
  }
  public function validateName($string)
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
  public function setFirstname($first_name)
  {
    $user = new User();
    if($user->validateName($first_name) ==1)
    {
      $this->fname = $first_name;
    }
    else
    {
      $this->fname = "NULL";
    }
  }
  public function getFirstname()
  {
    return $this->fname;
  }
  public function setLastname($last_name)
  {
    $user = new User();
    if($user->validateName($last_name) == 1)
    {
      $this->lname = $last_name;
    }
    else
    {
      $this->lname = "NULL";
    }
  }
  public function setSex($sex)
  {
    $this->sex = $sex;
  }
  public function getSex()
  {
    return $this->sex;
  }
  public function getLastname()
  {
    return $this->lname;
  }
  public function validatePhone($phone,$link)
  {
    //"0723302232"
     $out= 0;
     $sql = "SELECT * FROM `user` WHERE phone= \"$phone\" ";
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
  public function setPhone($phone, $link)
  {
    $user = new User();
    if($user->validatePhone($phone, $link) == 1)
    {
      $this->phone = $phone;
    }
    else
    {
      $this->phone = "NULL";
    }
  }
  public function getPhone()
  {
    return $this->phone;
  }
  public function validateId($idNumber)
  {
    //Check the size
    $out = 0;
    $idNumber = trim($idNumber," ");
    $int_id = (int)$idNumber;
    if($int_id > 0)
    {
      //9910230093082
      if(ctype_digit($idNumber) && strlen($idNumber) ==13)
      {
        if(substr($idNumber,2,2) != "00")
        {
          if(substr($idNumber,4,2)!="00")
          {
            $out =1;
          }
        }
      }
    }
    return $out;
  }
  public function setId($idNumber, $link)
  {
    $user = new User();
    if($user->validateId($idNumber) == 1 && $user->checkIdNumber($idNumber, $link) == 1)
    {
      $this->idNumber = $idNumber;
    }
    else
    {
     $this->idNumber = "NULL";
    }
  }
  public function getId()
  {
    return $this->idNumber;
  }
  public function getUserLabel()
  {
      $label = new Label();
      $label_increment = "";
      $label->set_label("", "ID Number: ".$this->idNumber, "");
      $label_increment .= "\n". $label->get_label() . "<br>";
      $label->set_label("", "First Name: ".$this->fname, "");
      $label_increment .= "\n". $label->get_label() . "<br>";
      $label->set_label("","Last Name: ". $this->lname, "");
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
  public function validateSex($idNumber, $sex)
  {
    $out ="Sex does not match your ID Number";
    $idNumber = substr($idNumber, 6, 4);
    if((int)$idNumber > 4999 && $sex =="M")
    {
      $out = "Good";
      return $out;
    }
    elseif((int)$idNumber < 5000 && $sex == "F")
    {
      $out = "Good";
      return $out;
    }
    else
    {
      return $out;
    }
  }
  public function viewSql()
  {
    //I think we need to validate the sex in here - 
    $sql = "INSERT INTO `user` (`fName`, `lName`, `idNumber`, `phone`, `email`, `cAddress`, `password`) VALUES\n"
        . "('$this->fname', '$this->lname', '$this->idNumber', '$this->phone', '$this->email', \"$this->address\", \"$this->password\")";
    return $sql;
  }
}
