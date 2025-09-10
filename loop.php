<?php

// Use a for loop to print numbers from 1 to 10.
for ($i = 1; $i <= 10; $i++) {
    echo $i . "<br>";
}

echo "<br>"; 

// Modify the code to print the multiplication table of 5.
$number = 5;
echo "Multiplication table of " . $number . ":<br>";

for ($i = 1; $i <= 10; $i++) {
    $result = $number * $i;
    echo $number . " x " . $i . " = " . $result . "<br>";
}

?>