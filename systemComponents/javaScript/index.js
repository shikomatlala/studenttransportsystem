//------------------------
//- USER LOGIN FUNCTIONS - 
//------------------------

function validateNameInput(){
    //Check if the password is strong or weak
    //Check if special characters are there.
    var nameInput = document.getElementById(this.id);
    nameInput.value = nameInput.value.trim();
    var specialCharFormat = /[`!@$%^&* ()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    var numFormat = /[012345789]/;
    if(specialCharFormat.test(nameInput.value) || numFormat.test(nameInput.value)){
        nameInput.style.borderBottomColor = "red";//Here we want to give you input inside the 
        nameInput.style.color = "red";
        document.getElementById("addMember").disabled = true;
    }
    else{
        nameInput.style.borderBottomColor = "rgb(0, 153, 255)";
        nameInput.style.color = "rgb(1, 37, 83)";
        document.getElementById("addMember").disabled = false;
    }
}