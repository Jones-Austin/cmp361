<?php

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // input field
    $name = $_POST['name'];
    $age = $_POST['age'];

    if (!empty($name) && !empty($age)) {
        // Display the greeting 
        echo "Hello, " . $name . "! You are " . $age . " years old.";
    } else {
        echo "Please fill in all fields.";
    }
}
?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name: <input type="text" name="name"><br>
    Age: <input type="text" name="age"><br>
    <input type="submit">
</form>
