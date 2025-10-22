<?php
function findMaximum($numbers) {
    /*
     * Returns the largest number in an array.
     *
     * @param array $numbers - list of numeric values
     * @return int|float|null - the largest number or null if the array is empty
     */
    
    if (empty($numbers)) {
        return null; // handle empty array
    }

    $maxNum = $numbers[0];
    
    foreach ($numbers as $num) {
        if ($num > $maxNum) {
            $maxNum = $num;
        }
    }
    return $maxNum;
}

// Example usage
$data = [3, 7, 2, 9, 5];
echo "Maximum value: " . findMaximum($data);
?>
