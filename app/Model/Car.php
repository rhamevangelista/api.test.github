<?php

/**
 * Class Car
 *
 * Car data connected to Car Table in DB
 */

namespace App\Model;

use App\Model\Model;

class Car extends Model
{
    protected $table = 'car';
    protected $primaryKey = 'id';
    protected $fillable = array('model_name', 'model_type', 'model_brand', 'model_year');
    protected $additionalFillableOnCreate = array('model_date_added');
    protected $nonfillable = array('model_date_modified');

    /**
     * Constructor
     *
     * Initialize variables in the Model Class
     *
     * @param string $db Database connection
     *
     * @return none
     *
     * @access public
     */
    public function __construct($db)
    {
        parent::__construct($db, $this->table);
    }
}
