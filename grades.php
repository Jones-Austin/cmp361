<?php

// Define a variable for the grade and assign it a number (0-100).
$grade = 85;

//if-elseif-else statement
if ($grade >= 90) {
    echo "Your grade is A.";
} elseif ($grade >= 80) {
    echo "Your grade is B.";
} elseif ($grade >= 70) {
    echo "Your grade is C.";
} else {
    echo "You failed.";
}

?>
