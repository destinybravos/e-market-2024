<?php

    function validateInputs(array $data, array $constraints) : bool | string
    {

        foreach ($constraints as $field => $constraint) {
            if ($constraint == 'required') {
                if (!existsInArray($field, $data)) {
                    throw new Exception($field . " is required.", 422);
                }

                if (empty($data[$field])) {
                    throw new Exception($field . " does not have a value.", 422);
                }
            }
        }

        return true;
    }


    function existsInArray(string $needle, array $hastack, string $arrayType = 'assoc') : bool{

        if ($arrayType == 'assoc') {
            foreach ($hastack as $key => $value) {
                if ($key == $needle) {
                    return true;
                }
            }
        }

        return false;
    }

    function validateInputsAdvanced(array $data, array $constraints) : bool | string
    {
        foreach ($constraints as $field => $constraint) {
            foreach ($constraint as $constraintName) {
                if ($constraintName == 'required') {
                    if (!existsInArray($field, $data)) {
                        throw new Exception($field . " is required.", 422);
                    }
    
                    if (empty($data[$field])) {
                        throw new Exception($field . " does not have a value.", 422);
                    }
                }

                if ($constraintName == 'email') {
                    $value = explode('@', $data[$field]);
                    if (count($value) < 2) {
                        throw new Exception("The field '" . $field . "' must be a valid email address", 422);
                    }
                }

                // Checking for unique fields
                if (str_contains($constraintName, 'unique')) {
                    $table = explode(':', $constraintName)[0];
                    if (isExists($table, $field, $data[$field])) {
                        throw new Exception("The email '$data[$field]' is already in use by another user.", 422);
                    }
                }

                // Checking for min
                if (str_contains($constraintName, 'min')) {
                    $min = (int)explode(':', $constraintName)[1];
                    if ($min > strlen($data[$field])) {
                        throw new Exception("$field must be a minimum of $min characters", 422);
                    }
                }

            }
        }

        return true;
    }

    function isExists($table, $field, $value) : bool {
        $conn = new MySQLi("localhost", "root", "", "school_mgt");
        $sqlString  = "SELECT * FROM $table WHERE $field='$value'";
        $execQuery = $conn->query($sqlString);

        return $execQuery->num_rows > 0;
    }