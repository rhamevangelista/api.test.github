<?php

/**
 * Class Model
 *
 * CRUD Query template for different table Model
 */

namespace App\Model;

class Model
{
    private $conn;

    protected $table;
    protected $primaryKey = 'id';
    protected $fillable;
    protected $nonfillable;
    protected $additionalFillableOnCreate;

    /**
     * Constructor
     *
     * Initialize db connection and table
     *
     * @param object $db    Database connection
     * @param string $table Table name
     *
     * @return none
     *
     * @access public
     */
    public function __construct($db, $table)
    {
        $this->conn = $db;
        $this->table = $table;
    }

    /**
     * Get All Method
     *
     * Get all records from the table
     *
     * @return array
     *
     * @access public
     */
    public function getAll()
    {
        $query = "
            SELECT * FROM " . $this->table;

        try {
            $data = $this->conn->query($query);
            $data->execute();

            if ($data->rowCount()) {
                $result = $data->fetchAll(\PDO::FETCH_ASSOC);
                return array(
                    "error" => false,
                    "message" => $result,
                    "status" => "200 OK"
                );
            } else {
                return array(
                    "error" => true,
                    "message" => "No records found in the table.",
                    "status" => "404 Not Found"
                );
            }
        } catch (\PDOException $e) {
            return array(
                "error" => true,
                "message" => $e->getMessage(),
                "status" => "500"
            );
        }
    }

    /**
     * Find Method
     *
     * Search record by ID
     *
     * @param string $id Record ID
     *
     * @return array
     *
     * @access public
     */
    public function find($id = 0)
    {
        $query = "
            SELECT 
                *
            FROM
            " . $this->table . "
            WHERE id = ?;
        ";

        try {
            $data = $this->conn->prepare($query);
            $data->execute(array($id));

            if ($data->rowCount()) {
                $result = $data->fetchAll(\PDO::FETCH_ASSOC);
                return array(
                    "error" => false,
                    "message" => $result,
                    "status" => "200 OK"
                );
            } else {
                return array(
                    "error" => true,
                    "message" => "Record not found.",
                    "status" => "404 Not Found"
                );
            }
        } catch (\PDOException $e) {
            return array(
                "error" => true,
                "message" => $e->getMessage(),
                "status" => "500"
            );
        }
    }

    /**
     * Create Method
     *
     * Create a new record
     *
     * @param array $payload Input Parameters
     *
     * @return array
     *
     * @access public
     */
    public function create($payload)
    {
        //build the insert query
        $fillFields = array_merge($this->fillable, $this->additionalFillableOnCreate);
        $keys = implode(', ', $fillFields);
        foreach ($fillFields as $field) {
            $fieldValues[] = $payload[$field];
        }
        $fieldValues = "'" . implode("', '", $fieldValues) . "'";

        $query = "
            INSERT INTO " . $this->table . " 
            ($keys) 
            VALUES ($fieldValues)";

        try {
            $data = $this->conn->prepare($query);
            $data->execute();

            if ($data->rowCount()) {
                return array(
                    "error" => false,
                    "message" => "Record successfully added.",
                    "status" => "201 Created"
                );
            } else {
                return array(
                    "error" => true,
                    "message" => "Record not saved.",
                    "status" => "404 Not Found"
                );
            }
        } catch (\PDOException $e) {
            return array(
                "error" => true,
                "message" => $e->getMessage(),
                "status" => "500"
            );
        }
    }

    /**
     * Update Method
     *
     * Update existing record
     *
     * @param array $payload Input Parameters
     *
     * @return array
     *
     * @access public
     */
    public function update($payload)
    {
        //build the update query
        $id = $payload[$this->primaryKey];
        foreach ($this->fillable as $field) {
            $updateDataArr[] = $field . " = '" . $payload[$field] . "'";
        }
        $updateData = implode(", ", $updateDataArr);

        $query = "UPDATE 
            " . $this->table . " 
            SET 
                $updateData
            WHERE $this->primaryKey = $id";

        try {
            $data = $this->conn->prepare($query);
            $data->execute();

            if ($data->rowCount()) {
                return array(
                    "error" => false,
                    "message" => "Record " . $this->model_name . " successfully updated.",
                    "status" => "200 OK"
                );
            } else {
                return array(
                    "error" => true,
                    "message" => "Nothing to update.",
                    "status" => "200 OK"
                );
            }
        } catch (\PDOException $e) {
            return array(
                "error" => true,
                "message" => $e->getMessage(),
                "status" => "500"
            );
        }
    }

    /**
     * Delete Method
     *
     * Delete existing record
     *
     * @param string $id Record ID
     *
     * @return array
     *
     * @access public
     */
    public function delete($id)
    {
        //process delete
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";

        try {
            $data = $this->conn->prepare($query);
            $data->bindParam(1, $id);
            $data->execute();

            if ($data->rowCount()) {
                return array(
                    "error" => false,
                    "message" => "Record ID " . $id . " successfully deleted.",
                    "status" => "200 OK"
                );
            } else {
                return array(
                    "error" => true,
                    "message" => "Record not found.",
                    "status" => "404 Not Found"
                );
            }
        } catch (\PDOException $e) {
            return array(
                "error" => true,
                "message" => $e->getMessage(),
                "status" => "500"
            );
        }
    }
}
