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
        $this->process_line();
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

        /**
     * Check if line is valid and destructure
     */
    private function process_line() {
        if ($this->is_valid_line())
        {
            if ($this->line_type == "C")
            {
                $this->destructure_c();
            } else if ($this->line_type == "D")
            {
                $this->destructure_d();
            }
        }
    }

    /**
     * Check if Line is valid (structure and possible values)
     * with regex
     */
    private function is_valid_line() {
        $char = substr($this->line_string, 0, 1);
        if ($char == "C"){
            $this->line_type = "C";

            $pattern = "/^(C)\s(\d{1,2}(\.\d)?)\s(\d{1,2}(\.\d{1,2}(\.\d)?)?)\s([PN])\s(([012]\d)\.([01]\d)\.([12]\d{3}))\s(\d+)$/";
            if (preg_match($pattern, $this->line_string) === 1) {
                return true;
            } else {
                throw new Exception("Line (C-line) is not valid line.");
            }
        } else if ($char == "D") {
            $this->line_type = "D";

            $pattern = "/^(D)\s((\d{1,2}(\.\d)?)|(\*))\s((\d{1,2}(\.\d{1,2}(\.\d)?)?)|(\*))\s([PN])\s(([01]\d)\.([01]\d)\.([12]\d{3})(\-([012]\d)\.([01]\d)\.([12]\d{3}))?)$/";
            if (preg_match($pattern, $this->line_string) === 1) {
                return true;
            } else {
                throw new Exception("Line (D-line) is not valid line.");
            }
        } else {
            throw new Exception("Line has to start with character C or D.");
        }
    }

    private function destructure_c() {
        // Split into "groups" (exploded by whitespace)
        $groups = explode(" ", $this->line_string);

        // Service ID & Variation ID
        $arr = explode(".", $groups[1]);
        if (isset($arr[0])) { $this->service_id = $arr[0]; }
        if (isset($arr[1])) { $this->variation_id = $arr[1]; }

        // Question type ID, Category & Subcategory ID
        $arr = explode(".", $groups[2]);
        if (isset($arr[0])) { $this->question_type_id = $arr[0]; }
        if (isset($arr[1])) { $this->category_id = $arr[1]; }
        if (isset($arr[2])) { $this->subcategory_id = $arr[2]; }

        // Response type
        $this->response_type = $groups[3];

        // Response date
        $this->date[] = $groups[4];

        // Waiting time
        $this->time = $groups[5];
    }

    private function destructure_d() {
        $groups = explode(" ", $this->line_string);

        // Service ID & Variation ID
        $arr = explode(".", $groups[1]);
        if (isset($arr[0])) { $this->service_id = $arr[0]; }
        if (isset($arr[1])) { $this->variation_id = $arr[1]; }

        // Question type ID, Category & Subcategory ID
        $arr = explode(".", $groups[2]);
        if (isset($arr[0])) { $this->question_type_id = $arr[0]; }
        if (isset($arr[1])) { $this->category_id = $arr[1]; }
        if (isset($arr[2])) { $this->subcategory_id = $arr[2]; }

        // Response type
        $this->response_type = $groups[3];

        // Response date
        $this->date = explode("-", $groups[4]);
    }

}

?>