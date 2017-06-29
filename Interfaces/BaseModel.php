<?php namespace igniteStack\Interfaces;

use igniteStack\Interfaces\Core;
use igniteStack\System\ErrorHandling\Exception;
use igniteStack\System\Storage\DatabaseStore;


abstract class BaseModel extends Core
{
    public $QueryType;
    public $Field;
    public $Operator;
    public $Value;


    /**
     * Allows overloading with chained function calls
     * @param $a
     * @param $b
     * @return $this|array
     */
    public function __call($a, $b)
    {
        switch (strtolower($a)) {
            case "findwhere":
            case "findallwhere":
            case "deleteallwhere":
                $this->QueryType = strtolower($a);
                $this->Field = strtolower($b[0]);
                break;
            case "equals":
            case "is":
            case "like":
            case "islike":
            case "not":
            case "isnot":
            case "morethan":
            case "lessthan":
                $this->Operator = $this->convertOperator($a);
                $this->Value = $b[0];

                // Abstract the query (if all fields are available)
                return $this->decideQuery();
                break;
        }

        // No "is" "equals" etc then we need to return the object
        // as we are only on the "findAllWhere" "findAll" etc stage of chaining.
        return $this;
    }


    /**
     * @param $operator
     * @return string
     */
    private function convertOperator ($operator)
    {
        switch ($operator) {
            case "equals":
                return '=';
            case "is":
                return '=';
            case "islike":
                return 'LIKE';
            case "not":
                return '!=';
            case "isnot":
                return '!=';
            case "morethan":
                return '>';
            case "lessthan":
                return '<';
        }
        return $operator;
    }


    /**
     * Decide on what query to run
     * @return array
     */
    public function decideQuery()
    {
        if (empty($this->QueryType) or empty($this->Field) or empty($this->Operator) or (empty($this->Value) and $this->Value != 0))
            (new Exception)->cast('QueryConstruction', 500);

        switch ($this->QueryType) {

            case "findwhere":
            case "findallwhere":
                return $this->prepareFindAllWhere();
            case "deleteallwhere":
                return $this->prepareDeleteAllWhere();
        }

        //return false;
    }


    /**
     * Prepare Select All Where Query
     * @return array
     */
    public function prepareFindAllWhere ()
    {
        $fieldList = '';

        // Get the name of the Model
        $fields = get_class_vars(get_class($this));

        foreach ($fields as $k => $v) {
            if ($k == 'Constraints' || $k == 'QueryType' || $k == 'Field' || $k == 'Operator' || $k == 'Value') continue;
            $fieldList .= strtolower($k) . ", ";
        }
        $fieldList = rtrim($fieldList, ", ");

        // Run a select query with given paramters
        return $this->abstractSelect($fieldList, $this->get_model_name($this), $this->Field, $this->Operator);
    }


    /**
     * Prepare Delete All Where Query
     * @return array
     */
    public function prepareDeleteAllWhere ()
    {
        $fieldList = '';

        // Get the name of the Model
        $fields = get_class_vars(get_class($this));

        foreach ($fields as $k => $v) {
            if ($k == 'Constraints' || $k == 'QueryType' || $k == 'Field' || $k == 'Operator' || $k == 'Value') continue;
            $fieldList .= strtolower($k) . ", ";
        }
        $fieldList = rtrim($fieldList, ", ");

        // Run a select query with given paramters
        return $this->abstractDelete($fieldList, $this->get_model_name($this), $this->Field, $this->Operator);
    }


    /**
     * Perform a Select Query
     * @param $fieldList
     * @param $modelName
     * @param $fieldName
     * @param $Operator
     * @return array
     */
    public function abstractSelect ($fieldList, $modelName, $fieldName, $Operator)
    {
        $dbh = (new DatabaseStore)->engine();

        $stmt = $dbh->prepare("SELECT $fieldList FROM " . $modelName . " WHERE " . $fieldName . " " . $Operator . " :" . $fieldName);
        $stmt->bindParam(":".$this->Field, $this->Value);
        $stmt->execute();
        $r = $stmt->fetchAll();

        $stmt = null;
        $dbh = null;
        return $r;
    }



    /**
     * Delete all where xyz
     * @param $fieldList
     * @param $modelName
     * @param $fieldName
     * @param $Operator
     * @return array
     */
    public function abstractDelete ($fieldList, $modelName, $fieldName, $Operator)
    {
        $dbh = (new DatabaseStore)->engine();

        $stmt = $dbh->prepare("DELETE FROM " . $modelName . " WHERE " . $fieldName . " " . $Operator . " :" . $fieldName);
        $stmt->bindParam(":".$this->Field, $this->Value);
        $stmt->execute();

        $stmt = null;
        $dbh = null;
        return true;
    }



    /**
     * Insert new data into Model
     */
    public function save ()
    {
        $fieldList = '';
        $fieldInputs = '';

        $fields = get_class_vars(get_class($this));

        foreach ($fields as $k => $v) {
            if ($k=='Constraints' or $k=='QueryType' or $k=='Field' or $k=='Operator' or $k=='Value') continue;
            $fieldList .= strtolower($k) . ", ";
            $fieldInputs .= ":" . strtolower($k) . ", ";
        }
        $fieldList = rtrim($fieldList, ", ");
        $fieldInputs = rtrim($fieldInputs, ", ");

        //die("INSERT INTO " . $this->get_model_name($this) . " (" . $fieldList . ") VALUES (" . $fieldInputs . ")");
        $dbh = (new DatabaseStore)->engine();
        $stmt = $dbh->prepare("INSERT INTO " . $this->get_model_name($this) . " (" . $fieldList . ") VALUES (" . $fieldInputs . ")");

        foreach ($fields as $k => $v) {
            if ($k=='Constraints' or $k=='QueryType' or $k=='Field' or $k=='Operator' or $k=='Value') continue;
            $stmt->bindParam(":".strtolower($k), $this->$k);
        }
        if ($stmt->execute())
            $response = true;

        $stmt = null;
        $dbh = null;

        return $response;
    }





    /**
     * Prepare Bespoke Select All Where Query
     * @return array
     */
    public function get_adverts_year_and_period ($year, $period)
    {
        $fieldList = '';

        // Get the name of the Model
        $modelName = get_class($this);
        $fields = get_class_vars(get_class($this));

        foreach ($fields as $k => $v) {
            if ($k == 'Constraints' || $k == 'QueryType' || $k == 'Field' || $k == 'Operator' || $k == 'Value') continue;
            $fieldList .= strtolower($k) . ", ";
        }
        $fieldList = rtrim($fieldList, ", ");

        $dbh = (new DatabaseStore)->engine();

        $stmt = $dbh->prepare("SELECT $fieldList FROM " . $this->get_model_name($this) . " WHERE year = :year AND period = :period");
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':period', $period);
        $stmt->execute();
        $r = $stmt->fetchAll();

        $stmt = null;
        $dbh = null;
        return $r;
    }





    /**
     * Prepare Bespoke Select All Where Query
     * @return array
     */
    public function get_adverts_year_and_period_and_pageid ($year, $period, $pageid)
    {
        $fieldList = '';

        // Get the name of the Model
        $modelName = get_class($this);
        $fields = get_class_vars(get_class($this));

        foreach ($fields as $k => $v) {
            if ($k == 'Constraints' || $k == 'QueryType' || $k == 'Field' || $k == 'Operator' || $k == 'Value') continue;
            $fieldList .= strtolower($k) . ", ";
        }
        $fieldList = rtrim($fieldList, ", ");


        $dbh = (new DatabaseStore)->engine();

        $stmt = $dbh->prepare("SELECT $fieldList FROM " . $this->get_model_name($this) . " WHERE year = :year AND period = :period AND pageid = :pageid");
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':period', $period);
        $stmt->bindParam(':pageid', $pageid);
        $stmt->execute();
        $r = $stmt->fetchAll();

        $stmt = null;
        $dbh = null;
        return $r;
    }




    private function get_model_name ($modelClass) {
        $namespaceList = explode('\\', get_class($modelClass));
        return strtolower($namespaceList[count($namespaceList)-1]);
    }
}
