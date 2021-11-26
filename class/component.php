<?php
include_once "form.php";
include_once "student.php";

function newUser()
{
    $input = new Input();
    $label = new Label();

    $input_wrapper = "";
    $label->setLabel("first_name", "First Name", "", "lblFName");
    $input->setInput("text", "first_name", "", "First Name", "input_", "fname", "oninput", "validateName(this.id, 'lblFName')");
    $input_wrapper .= $label->getLabel() . "<br>\n";
    $input_wrapper .= $input->getInput() . "<br><br>\n";
    //Last Name
    $label->setLabel("last_name", "Last Name", "", "lblLName");
    $input->setInput("text", "last_name", "", "Last Name", "input_", "lname", "oninput", "validateName(this.id, 'lblLName')");
    $input_wrapper .= $label->getLabel() . "<br>\n";
    $input_wrapper .= $input->getInput() . "<br><br>\n";
    //ID Number
    $label->set_label_("id_nr", "ID Number", "", "lblId_nr");
    $input->setInput("text", "id_nr", "", "ID Number", "input_", "id_nr", "oninput", "validate_id()");
    $input_wrapper .= $label->get_label_() . "<br>\n";
    $input_wrapper .= $input->getInput() . "<br><br>\n";
    //Select Sex
    $label->set_label_("sex", "Sex", "", "lblSex");
    $input_wrapper .= $label->get_label_() . "<br>\n";
    $select = new Select();
    $select->setSelect("sex","sex", "input_", "onchange", "validate_id()");
    $select->set_option("M", "Male");
    $gender_option = "\t".$select->get_option();
    $select->set_option("F","Female");  
    $gender_option .= "\t".$select->get_option();
    $select_output = $select->getSelect($gender_option);
    $input_wrapper.= $select_output. "<br>";
    //Phone Number
    $label->set_label_("phone", "Phone Number", "", "lblPhone");
    $input->setInput("text", "phone", "", "e.g. 0765870538", "input_", "phone", "oninput", "validatePhone()");
    $input_wrapper .= $label->get_label_() . "<br>\n";
    $input_wrapper .= $input->getInput() . "<br><br>\n";
    //Email Address
    $label->set_label_("email", "Email Address", "", "lblEmail");
    $input->setInput("text", "email", "", "Email", "input_", "email", "oninput", "validateEmail()");
    $input_wrapper .= $label->get_label_() . "<br>\n";
    $input_wrapper .= $input->getInput() . "<br><br>\n";

    $label->set_label("address", "Home Address", "");
    $input->set_input("text", "address", "", "Home Address", "input_");
    $input_wrapper .= $label->get_label() . "<br>\n";
    $input_wrapper .= $input->get_input_text() . "<br><br>\n";

    $input_wrapper .= "<h3 class=\"center_el\">Enter Password</h3>";

    $label->setLabel("pword1", "Password", "", "lblPword1");
    //$label->set_label("password", "Password", "");
    $input->setInput("password", "password", "", "Password", "input_", "pword1", "oninput", "validatePassword(this.id,'lblPword1')");
    //$input->set_input("text", "password", "", "Password", "");
    $input_wrapper .= $label->getLabel() . "<br>\n";
    $input_wrapper .= $input->getInput() . "<br><br>\n";

    //first _name
    $label->setLabel("pword2", "Password", "", "lblPword2");
    $input->setInput("password", "password", "", "Password", "input_", "pword2", "oninput", "validatePassword(this.id,'lblPword2')");
    $input_wrapper .= $label->getLabel() . "<br>\n";
    $input_wrapper .= $input->getInput() . "<br><br>\n";
    return $input_wrapper;
}

?>