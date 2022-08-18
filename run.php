<?php

$input_filename = "input.txt";

$read_lines = 0;

$handle = fopen($input_filename, "r");
if ($handle) {
    
    // Read file line by line
    while (($read = fgets($handle)) !== false) {
        
        // Line with line count
        if ($read_lines == 0) {
            $read_lines++;
            continue;
        }


        $read_lines++;
    }

    fclose($handle);
}

?>