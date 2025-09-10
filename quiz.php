<?php

// Check if the form has been submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST['number'];

    // Validate that the input is a number.
    if (is_numeric($number)) {
        // If a number divided by 2 has a remainder of 0, it is even.
        if ($number % 2 == 0) {
            echo $number . " is an even number.";
        } else {
            echo $number . " is an odd number.";
        }
    } else {
        echo "Please enter a valid number.";
    }
}
?>

<!-- Simple HTML form to ask the user for a number -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Enter a number: <input type="text" name="number"><br>
    <input type="submit" value="Check">
</form>