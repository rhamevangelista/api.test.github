<?php

/**
 * CarController.php
 * Car Controller Class
 */

namespace App\Controller;

use App\Model\Car;

class CarController
{

    private $db;
    private $id;
    private $requestMethod;

    private $car;

    /**
     * Constructor
     *
     * Initialize variables that will be used in connecting to DB
     *
     * @param string $db            Database connection
     * @param string $requestMethod API request type
     * @param string $id            Record ID came from $_GET['id']
     *
     * @return none
     *
     * @access public
     */
    public function __construct($db, $requestMethod, $id = 0)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->id = $id;

        $this->car = new Car($db);
    }

    /**
     * Process Request Method
     *
     * This will check if what Car Controller method will use in each API request type
     *
     * @return json
     *
     * @access public
     */

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getAllCars($this->id);
                break;
            case 'POST':
                $response = $this->createCar();
                break;
            case 'PUT':
                $response = $this->updateCar();
                break;
            case 'DELETE':
                $response = $this->deleteCar($this->id);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        //output the header and body response
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    /**
     * Get all cars or single record Method
     *
     * This will return all cars record or single record search by ID
     *
     * @return array
     *
     * @access public
     */
    private function getAllCars($id)
    {
        if ($id != 0) {
            $result = $this->car->find($id);
        } else {
            $result = $this->car->getAll();
        }
        $response['status_code_header'] = 'HTTP/1.1 ' . $result['status'];
        $response['body'] = json_encode($result['message']);
        return $response;
    }

    /**
     * Create Car Method
     *
     * This will create a new car record
     *
     * @return array
     *
     * @access public
     */
    private function createCar()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);

        $input['model_date_added'] = date("Y-m-d H:i:s");
        $create = $this->car->create($input);

        $response['status_code_header'] = 'HTTP/1.1 ' . $create['status'];
        $response['body'] = $create['message'];
        return $response;
    }

    /**
     * Update Car Method
     *
     * This will update a existing car record by ID
     *
     * @return array
     *
     * @access public
     */
    private function updateCar()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);

        $id = $input['id'];
        $result = $this->car->find($id);
        if ($result['error']) {
            return $this->notFoundResponse();
        }

        $update = $this->car->update($input);

        $response['status_code_header'] = 'HTTP/1.1 ' . $update['status'];
        $response['body'] = $update['message'];
        return $response;
    }

    /**
     * Delete Car Method
     *
     * This will update a existing car record by ID
     *
     * @param string $id            Record ID came from $_GET['id']
     *
     * @return array
     *
     * @access public
     */
    private function deleteCar($id = 0)
    {
        $result = $this->car->find($id);
        if ($result['error']) {
            return $this->notFoundResponse();
        }
        $delete = $this->car->delete($id);

        $response['status_code_header'] = 'HTTP/1.1 ' . $delete['status'];
        $response['body'] = $delete['message'];
        return $response;
    }

    /**
     * Return 404 Method
     *
     * This will return a 404 Header when the record cannot find
     *
     * @return array
     *
     * @access public
     */
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = "Record not found.";
        return $response;
    }
}
