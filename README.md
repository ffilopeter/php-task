# Quality Unit | php-task

## Run the program

> To run the program, put your input lines into `input.txt` file and run `run.php` script in console.

## Assignment - The Problem

Webhosting company provide customer support via email. They record reply waiting time, type of question, category and service. To improve customer satisfaction, they need analytical tool to evaluate these data.

### Input

Company provide 10 different services, each with 3 variations. Questions are divided into 10 types, each can belong to 20 categories, a category can have 5 sub categories.

First line contains count S (<= 100.000) of all lines.
Every line starts with character **C** (waiting time line) or **D** (query line).

`C service_id[.variation_id] question_type_id[.category_id[.sub-category_id]] P/N date time`

Values in square brackets are optional. Service `9.1` represents service `9` of variation `1`. Question type `7.14.4` represents question type `7` category `14` and sub-category `4`. Response type `P` (first answer) or `N` (next answer). Response date format is `DD.MM.YYYY`, for example `27.11.2012` (27. november 2012). Time in minutes represents waiting time.

**Similarly query line:**

`D service_id[.variation_id] question_type_id[.category_id[.sub-category_id]] P/N date_from[-date_to]`

Represents query, it prints out average waiting time of all records matching specific criterias. `service_id` and `question_type_id` can have special value `*`, it means query match all services/question types. In case of value `*`, no service variation nor service category/sub-category can be specified.

### Output

Query line of type `D` prints out average waiting time rounded to minutes. Only matching lines defined before query line are counted. It prints out `-` if output is not defined.

### Example
**Input:**
```
7
C 1.1 8.15.1 P 15.10.2012 83
C 1 10.1 P 01.12.2012 65
C 1.1 5.5.1 P 01.11.2012 117
D 1.1 8 P 01.01.2012-01.12.2012
C 3 10.2 N 02.10.2012 100
D 1 * P 08.10.2012-20.11.2012
D 3 10 P 01.12.2012
```

**Output:**
```
83
100
-
```

**Explanation:**
1. Query at line 5 is valid only for 1. data line, because others has different question type. First data line has question type `8.15.1` which match with query of question type `8`.
2. Query is valid only for 1. and 3. data lines, 2. data line does not match date filter and 4. data line has different response type (`N`). Result is `83+117/2`
3. Query does not match any data line, therefore result is `-`
