<?php
class DB{
    private static $instance = null;
    private $_pdo, $_query, $_error = false, $_results, $_count = 0;
    private function __construct(){
        try{
           # $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';port=3303;dbname=' . Config::get('mysql/db'), Config::get('mysql/username') , Config::get('mysql/password'));
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';port=3306;dbname=' . Config::get('mysql/db'), Config::get('mysql/username') , Config::get('mysql/password'));
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function query($sql, $params = array()){
        $this->error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $i = 1;
            if(count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($i, $param);
                    $i++;
                }
            }
            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    public function action($action, $table, $where = array()){
        if(count($where) === 3){
            $operators = array('=', '>','<','>=','<=');
            
            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];

            if(in_array($operator, $operators)){
                $query = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($query, array($value))->error()){
                    return $this;
                } else{
                    return false;
                }
            }
        }
        return false;
    }

    public function get($table, $where){
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where) {
        return $this->action('DELETE ', $table, $where);
    }

    public function insert($table, $fields = array()){
        $keys = array_keys($fields);
        $values = null;
        $i = 1;
        
        foreach($fields as $field){
            $values .= '?';
            if($i < count($fields)){
                $values .= ', ';
            }
            $i++;
        }

        $query = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

        if(!$this->query($query, $fields)->error()){
            return true;
        }
        return false;
    }

    public function update($table, $id, $fields){
        $set = '';
        $i = 1;

        foreach($fields as $name => $value){
            $set .= "{$name} = ?";

            if($i < count($fields)){
                $set .= ', ';
            }
            $i++;
        }
        $query = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if(!$this->query($query, $fields)->error()) {
            return true;
        } else{
            return false;
        }

        return false;
    }

    public function error(){
        return $this->_error;
    }

    public function getError(){
        if($this->_error)
            return implode(' | ', $this->_query->errorInfo());
    }

    public function getSingleResult(){
        return $this->results()[0];
    }

    public function results(){
        return $this->_results;
    }
    
    public function count(){
        return $this->_count;
    }
}