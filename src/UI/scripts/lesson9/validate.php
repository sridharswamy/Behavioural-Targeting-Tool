<?php
/***********************************************************************************************/
/* If nothing is posted then we exit */
/***********************************************************************************************/
if (!$_POST) {
	die("This file cannot be accessed directly!");
}



/***********************************************************************************************/
/* Define regular expression patterns */
/***********************************************************************************************/
$expEmail = 			'/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
$expLettersOnly = 		'/^[a-zA-Z ]+$/';
$expLettersNumbers = 	'/^[a-zA-Z0-9]*$/';



/***********************************************************************************************/
/* Define the function for checking the field length */
/***********************************************************************************************/
function validateLength($fieldValue, $minLength) {
	return (strlen(trim($fieldValue)) > $minLength);
}



/***********************************************************************************************/
/* Get the posted field values and validate each field */
/***********************************************************************************************/
$name 				= $_POST["name"];


$email 				= $_POST["email"];	
$password 			= $_POST["password"];	

$errorExists 		= false;
$errors 			= "Errors: <ul>";

// Name
if (!validateLength($name, 2)) {
	$errorExists = true;
	$errors .= "<li>The name is too short!</li>";
}
if (preg_match($expLettersOnly, $name) !== 1) {
	$errorExists = true;
	$errors .= "<li>The name can only contain letters and spaces!</li>";
}


// Email
if (preg_match($expEmail, $email) !== 1) {
	$errorExists = true;
	$errors .= "<li>The email address format is invalid!</li>";
}

// Password
if (!validateLength($password, 5)) {
	$errorExists = true;
	$errors .= "<li>The password is too short!</li>";
}
if (preg_match($expLettersNumbers, $password) !== 1) {
	$errorExists = true;
	$errors .= "<li>The password can only contain alphanumeric characters!</li>";
}


// If no errors, echo the results
if (!$errorExists) {
	echo "<h3>Success! The form has been submitted!</h3>"
		. "<p>Details:</p>"
		. "<ul>"
		. "<li>Name: $name</li>"
		. "<li>Email: $email</li>"
		. "</ul>";
} else {
	echo "<h3>Error! Please address the following issues:</h3>"
		. $errors;
}	
?>