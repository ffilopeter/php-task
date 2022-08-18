<?php

Class Line
{
    /**
     * (integer) line_index
     * Line index from input file
     */
    private $line_index = NULL;

    /**
     * (string) line_type
     * Line type can be either "C" or "D"
     * C-Line = waiting time line
     * D-Line = query line
     */
    private $line_type = NULL;

    /**
     * (string) service_id
     * Either a number or asterix (* for D-Line only)
     */
    private $service_id = NULL;

    /**
     * (string) variation_id
     * A number string or NULL if not set
     */
    private $variation_id = NULL;

    /**
     * (string) question_type_id
     * Either a number or asterix (* for D-Line only)
     */
    private $question_type_id = NULL;

    /**
     * (string) category_id
     * A number string or NULL if not set
     */
    private $category_id = NULL;

    /**
     * (string) subcategory_id
     * A number string or NULL if not set
     */
    private $subcategory_id = NULL;

    /**
     * (string) response_type
     * Either "P" or "N"
     * P = first answer
     * N = next answer
     */
    private $response_type = NULL;

    /**
     * (array) date
     * An array of dates
     * C-Line type single item in array
     * D-Line type range of dates (two items) or single date
     */
    private $date = array();

    /**
     * (string) time
     * A number string
     * Waiting time (C-Lines)
     */
    private $time = NULL;

    private $line_string;

    public function __construct($index, $string) {
        $this->line_index = $index;
        $this->line_string = $string;
    }

    /**
     * Get Line object property by name
     */
    public function get_property($prop) {
        return $this->{$prop};
    }

    /**
     * Check if Line is query line object (D-Line)
     */
    public function is_query_line() {
        return (isset($this->line_type) && $this->line_type == "D");
    }
}

?>