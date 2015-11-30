<?php

class SQLUtil
{
    /*
     * runSQL
     *
     * Given the provided SQL statement and data, runs the sequel statement.
     *
     * @param (string) (sql) A sql statement
     * @param (array) (array) data to be bound in the sql statement
     * @param (boolean) (update) whether the sequal statement is an update
     * @return (array) result array
     */
    public static function run($sql, $array, $update)
    {   
        // Initialize empty result array
        $result = [];

        try 
        {
            // If the connection is not initialized
            if (is_null($conn))
            {
                $servername = "localhost";
                $username = "root";
                $password = "password";
                $dbname = "employees";

                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);         
            }

            $stmt = $conn->prepare($sql);

            $stmt->execute($array);

            if (!$update)
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            else
                $result = "true";
        }
        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }

        return $result;
    }

}

?>