<?php

include "Line.class.php";

$input_filename = "input.txt";

/**
 * Read lines counter
 */
$read_lines = 0;

/**
 * Processed line returns Line object
 * and $line_objects store these objects
 */
$line_objects = array();

/**
 * Array of caught Exceptions
 */
$errors = array();

/**
 * Print results of query lines
 * (average waiting time)
 */
$results = array();

$handle = fopen($input_filename, "r");
if ($handle) {
    
    // Read file line by line
    while (($read = fgets($handle)) !== false) {
        
        // Line with line count
        // (ignore this for now)
        if ($read_lines == 0) {
            $read_lines++;
            continue;
        }

        // Line limit - process max 100.000 lines
        if ($read_lines == 100000) {
            break;
        }

        try {
            // Create new Line object
            $line = new Line($read_lines, $read);

            // Add new line object to global array
            $line_objects[] = $line;

            // Check if current line is "query line" (D-Line)
            if ($line->is_query_line()) {

                // If current line is query line
                // then check match with previous lines
                // and return matching line objects
                $matching = $line->match_query_line($line_objects);
                $count_matching = count($matching);
        
                // if any line objects match (c-lines) with query line
                // calculate average waiting time
                // and store it in global $results array
                if ($count_matching >= 1) {
                    if ($count_matching == 1) {
                        $results[] = $matching[0]->get_property("time");
                    } else {
                        // Calculate average waiting time
                        $average = 0;
                        for ($i = 0; $i < $count_matching; $i++) {
                            $average += $matching[$i]->get_property("time");
                        }
            
                        if ($average > 0) {
                            $results[] = ($average / $count_matching);
                        } else {
                            $results[] = "0";
                        }
                    }
                } else {
                    $results[] = "-";
                }
            }

        } catch (Exception $e) {
            $errors[] = $e;
        }

        // Update read lines counter
        $read_lines++;
    }

    fclose($handle);
}

if (count($errors) > 0) {
    // print exceptions or whatever...
}

if (count($results) > 0) {
    foreach ($results as $r) {
        echo $r . "\n";
    }
} else {
    echo "no matching lines\n";
}

?>