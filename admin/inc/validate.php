<?php 
$errors = [];
function checkName($name){
    if(!preg_match("/^[a-zA-Z]{3,} [a-zA-Z]{3,}$/",$name)){
        global $errors;
        $errors['username'] = 'username just be string not include number and must contain more than 3 leters and must enter first name and last name'; 
    }
}
function checkEmail($email){
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        global $errors;
        $errors['email']='Not Valid';
    }
}
function duplicateEmail($email){
    global $connect;
    $query = "SELECT `email` FROM `users` WHERE `email`='$email'";
    $result = $connect->query($query);
    if($result->rowCount() > 0){
        global $errors;
        $errors['duplicateEmail']='Duplicated Email';
    }
}
function checkpassword($password,$confirmPassword){
    if($confirmPassword != $password){
        global $errors;
        $errors['conPassword']='Confirm Password Not Equal Password';
    }
}
function checkBeNumber($price){
    if(!filter_var($price,FILTER_VALIDATE_INT)){
        global $errors;
        $errors['price']='Price Is Not A Number';
    }
}
function checkExt($ext,$allowedExt){
    if(!in_array($ext,$allowedExt)){
        global $errors;
        $errors['image']="Not allowed Extintion";
        }
    }
?>