<?php

namespace objCURD;

use mysqli;

class LibObj
{
    private $host = 'localhost';
    private $user_name = 'root';
    private $db_password = 'root';
    private $db_name = 'objcrud';
    private $data = array();

    private $conn_flag = false;
    private $mysqli = "";

    public function __construct()
    {
        //connection code
        if (!$this->conn_flag) {
            $this->mysqli = new mysqli($this->host, $this->user_name, $this->db_password, $this->db_name);
            if (!$this->mysqli->connect_error) {
                $this->conn_flag = true;
                // $this->data = 'connection successful';
                // array_push($this->data,'connection successful' );
                return true;
            } else {
                // $this->data = 'connection failed' . $this->mysqli->connect_error;
                array_push($this->data, 'connection failed' . $this->mysqli->connect_error);
                return false;
            }
        }
    }

    public function __destruct()
    {
        // connection close
        if ($this->conn_flag) {
            $this->mysqli->close();
            $this->conn_flag = false;
        }
    }

    public function create($data = null)
    {
        if ($data === null) {
            return false;
        }

        //get variable
        $str_field = '`';
        $str_field_values = "'";
        $str_field .= implode('`,`', array_keys($data));
        $str_field_values .= implode("','", array_values($data));
        $str_field .= '`';
        $str_field_values .= "'";

        //insert code
        $qry = 'INSERT INTO `users` (' . $str_field . ') VALUES (' . $str_field_values . ');';
        if ($this->mysqli->query($qry)) {
            // $this->data = 'record successfully created at id: ' . $this->mysqli->insert_id;
            array_push($this->data, 'record successfully created at id: ' . $this->mysqli->insert_id);
            // print_r($this->data);
            return true;
        } else {
            //error message
            // $this->data = 'record creatioin unsuccessful';
            array_push($this->data, 'record creatioin unsuccessful');
            // print_r($this->data);
            return false;
        }
    }
    public function get_total_pages($limit=0){
        if($limit == 0){
            $total_pages=1;
            array_push($this->data, $total_pages);
            return true;
        }

        // var_dump($limit);
        // die;

        $qry = 'SELECT * FROM `users` ';
        if ($result = $this->mysqli->query($qry)) {
            $total_records=$result->num_rows;
            $total_pages = ceil($total_records / $limit);
            array_push($this->data, $total_pages);
            return true;
        }else{
            array_push($this->data, 'something went wrong');
            return false;
        }
    }

    public function read($limit = 0, $page = 1)
    {
        // fetch code
        $qry = 'SELECT * FROM `users` ';
        //pagination logic
        if ($limit > 0) {
            $offset = ($page - 1) * $limit;
            $qry .= 'LIMIT ' . $offset . ',' . $limit;
        }
        if ($result = $this->mysqli->query($qry)) {
            if ($result->num_rows > 0) {
                // $this->data = $result->fetch_all(MYSQLI_ASSOC);
                array_push($this->data, $result->fetch_all(MYSQLI_ASSOC));
                // print_r($this->data);
                return true;
            } else {
                //error message
                // $this->data = 'no record to show';
                array_push($this->data, 'no records to display');
                return false;
            }
        } else {
            // $this->data = 'something went wrong';
            array_push($this->data, 'something went wrong');
            return false;
        }
        // Free result set
        $result->free_result();
    }

    public function get($id = null)
    {
        //fetch a single record
        if ($id === null) {
            return false;
        }
        $qry = 'SELECT * FROM `users`; ';
        if ($result = $this->mysqli->query($qry)) {
            if ($result->num_rows > 0) {
                // $this->data = $result->fetch_assoc();
                array_push($this->data, $result->fetch_assoc());
                // print_r($this->data);
                return true;
            } else {
                // error message
                // $this->data = 'no record to show';
                array_push($this->data, 'no record to show');
                return false;
            }
        } else {
            // error message
            // $this->data = 'something went wrong';
            array_push($this->data, 'something went wrong');
            return false;
        }
        // Free result set
        $result->free_result();
    }
    public function update($id = null, $data = null)
    {
        //update code
        if ($id === null) {
            return false;
        }
        if ($data === null) {
            return false;
        }

        $str = "`";
        foreach ($data as $key => $value) {

            $str .= $key . "`='" . $value . "', `";
        }
        $str = substr($str, 0, -3);


        //insert code
        $qry = "UPDATE `users` SET " . $str . " WHERE `id`=" . $id;
        if ($this->mysqli->query($qry)) {
            if ($this->mysqli->affected_rows > 0) {
                // $this->data = 'record successfully updated';
                array_push($this->data, 'record successfully updated');
                // print_r($this->data);
                return true;
            } else {
                //error message
                // $this->data = 'record update unsuccessful';
                array_push($this->data, 'record update unsuccessful');
                // print_r($this->data);
                return false;
            }
        } else {
            //error message
            // $this->data = 'something went wrong';
            array_push($this->data, 'something went wrong');
            // print_r($this->data);
            return false;
        }
    }
    public function delete($id = null)
    {
        // delete code
        if ($id === null) {
            return false;
        }
        $qry = 'DELETE FROM `users` WHERE `id`=' . $id;
        if ($this->mysqli->query($qry)) {
            if ($this->mysqli->affected_rows > 0) {
                // $this->data = 'record successfully deleted';
                array_push($this->data, 'record successfully deleted');
                // print_r($this->data);
                return true;
            } else {
                //error message
                // $this->data = 'record delete unsuccessful ';
                array_push($this->data, 'record delete unsuccessful');
                // print_r($this->data);
                return false;
            }
        } else {
            //error message
            // $this->data = 'something went wrong';
            array_push($this->data, 'something went wrong');
            // print_r($this->data);
            return false;
        }
    }

    public function getResult()
    {
        $value=array_pop($this->data);
        $this->data=array();
        return  $value;
    }
}
