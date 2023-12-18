<?php
namespace App\System\DB;
define("DB_OBJECT", "1");
define("DB_ARRAY", "2");
define("DB_ASSOC", "3");
define("DB_ROW", "4");
define("DB_DRIVER_MYSQL", "MYSQL");
define("DB_DRIVER_PGSQL", "PGSQL");
use Exception;
use App\System\Config;
class DB
{
    private $driver;
    /**
     * query variables
     */
    private $query;
    private $where;
    protected $columns;
    protected $table;
    protected $primary_key;
    public $last_query = "";
    private $params = [];
    private $pdo;
    public function __construct($table_name = '', $primary_key_column = 'id')
    {
        // get table name and primary key column from construct
        $this->table = $table_name;
        $this->primary_key = $primary_key_column;
        $config = new Config();
        $dsn = $config->get('db_driver') . ':';
        $dsn .= 'host=' . $config->get("db_host") . ';';
        $dsn .= 'port=' . $config->get("db_port") . ';';
        if (!empty($config->get("db_name"))) {
            $dsn .= 'dbname=' . $config->get("db_name") . ';';
        }
        $user_name = 'user=' . $config->get("db_user") . ';';
        $password = 'password=' . $config->get("db_password") . ';';
        $dbConnect = $dsn . $user_name . $password;
        // exit;
        $this->pdo = new \PDO(
            $dbConnect
        );
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->query = "";
    }
    private function build_where($where)
    {
        $where_array = [];
        // check where condains key value pair or array of conditions
        $key_count = count(array_keys($where));
        $value_count = count(array_values($where));
        if ($key_count == $value_count) {
            foreach ($where as $column => $condition) {
                $where_array[] = "$column = ?";
                $this->params[] = $condition;
            }
        } else {
            $where_array = $where;
        }
        $this->where = $where;
        return implode(" AND ", $where_array);
    }
    public function insert_archieves($sql, $inIDS)
    {
        try {
            $insertNominationStmt = $this->pdo->prepare($sql);
            $insertNominationResult = $insertNominationStmt->execute($inIDS);
            return $insertNominationResult;
        } catch (\PDOException $e) {
            // Handle the exception, e.g., log the error or return a specific value indicating failure.
            return false;
        }
    }
    public function insert_archieves_gallery($sql, $inIDS)
    {
        try {
            $insertNominationStmt = $this->pdo->prepare($sql);
            $params = [$inIDS];
            $insertNominationResult = $insertNominationStmt->execute($params);
            return $insertNominationResult;
        } catch (\PDOException $e) {
            // Handle the exception, e.g., log the error or return a specific value indicating failure.
            return false;
        }
    }
    public function insert($data)
    {
        $columns = array_keys($data);
        $values = array_values($data);
        $columns_string = implode(", ", $columns);
        $values_string = str_repeat("?,", count($values));
        // remove last , when adding str_repeat
        $values_string = substr($values_string, 0, -1);
        $this->query = "INSERT INTO {$this->table} ( $columns_string ) VALUES ( $values_string );";
        $stmt = $this->pdo->prepare($this->query);
        // reset the params for future queries once the execution is done
        $this->params = [];
        return $stmt->execute($values);
    }
    public function insertold($data)
    {
        return $this->driver->insert($data);
    }
    //@todo: remove
    private function quote($column)
    {
        $char = "";
        if ($this->driver == 'mysql') {
            $char = "``";
        }
        if ($this->driver == 'pgsql') {
        }
        return $char . $column . $char;
    }
    //@todo: remove
    private function safe_str($value)
    {
        return "'" . $value . "'";
    }
    public function set_query($query)
    {
        $this->query = $query;
        return $this;
    }
    /**
     * crud operations
     */
    public function select($columns = "*")
    {
        $this->query = "SELECT " . $columns;
        // echo  $this->query;
        return $this;
    }
    public function from($table = "")
    {
        if ($table == "") {
            exit("The table should not be empty");
        }
        $this->query .= " FROM " . $table;
        //   echo $this->query;
        //    exit;
        return $this;
    }
    public function join($table = "", $condition, $method)
    {
        if ($table == "") {
            exit("The table should not be empty");
        }
        $this->query .= ' ' . $method . " " . $table . " ON " . $condition;
        return $this;
    }
    //Old Like 
    // public function like($column_name, $condition)  
    // {
    //     $this->query .= "AND " . $column_name . " LIKE " . "'%?%'";
    //     $this->params[] = $condition;
    //     return $this;
    // }
    //Old Like 
    public function like($column_name, $condition)
    {
        $this->query .= " AND " . $column_name . " ILIKE " . "'%?%'";
        $this->params[] = $condition; // Add wildcards around the condition



        return $this;
    }
    public function wherelike($str, $condition)
    {
        $this->query .= " WHERE  " . $str . " LIKE " . "'%?%'";
        $this->params[] = $condition;
        return $this;
    }
    public function fetchfour($str)
    {
        $this->query .= " " . $str;
        return $this;
    }
    public function fetchtwo($str)
    {
        $this->query .= " " . $str;
        return $this;
    }
    public function where($where = null)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        // print_r( $where);
        //    exit;
        $where_string = null;
        if (is_array($where)) {
            $where_string .= $this->build_where($where);
        } else {
            $where_string .= $where;
        }
        //echo $where_string;
        if ($where_string != null) {
            $this->query .= " WHERE " . $where_string;
        }
        // echo $this->query;
        return $this;
    }
    public function orwhere($where = null)
    {
        $where_string = null;
        if (is_array($where)) {
            $where_string .= $this->build_where($where);
        } else {
            $where_string .= $where;
        }
        if ($where_string != null) {
            $this->query .= "  " . $where_string;
        }
        return $this;
    }
    public function limit($rows_per_page, $page_no = null)
    {
        $page_no = ((int) $page_no == 0) ? 1 : $page_no;
        $starting_index = 1 * $rows_per_page;
        $this->query .= " LIMIT $starting_index";
        //  echo   $this->query;
        return $this;
    }
    public function limitEmail($rows_per_page, $page_no = null)
    {
        $this->query .= " LIMIT $rows_per_page OFFSET $page_no";
        return $this;
    }
    public function limitPagination($rows_per_page, $page_no = null)
    {
        $this->query .= " LIMIT $rows_per_page OFFSET $page_no";
        return $this;
    }
    public function group_by($group_by)
    {
        $this->query .= " group by $group_by";
        return $this;
    }
    public function order_by($order_by)
    {
        $this->query .= " ORDER BY $order_by";
        //  echo  $this->query;
        return $this;
    }
    public function get_list($rows_per_page = "all", $page_no = 1, $result_type = null)
    {
        if ($rows_per_page != "all") {
            $this->limit($rows_per_page, $page_no);
        }
        $stmt = $this->pdo->prepare($this->query);
        //  $this->last_query = $this->interpolateQuery($this->query, $this->params);
        //echo $this->query."<br>";
        // exit;
        $stmt->execute($this->params);
        $this->params = [];
        $records = $stmt->fetchAll($this->getPdoResultType($result_type));
        return $records;
    }
    public function get_limited_list($rows_per_page = "11", $page_no = 1, $result_type = null)
    {
        if ($rows_per_page != "11") {
            $this->limit($rows_per_page, $page_no);
        }
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->params);
        $this->params = [];
        $records = $stmt->fetchAll($this->getPdoResultType($result_type));
        return $records;
    }
    public function get_one($result_type = null)
    {
        try {
            $stmt = $this->pdo->prepare($this->query);
            $stmt->execute($this->params);
            $this->params = [];
            $records = $stmt->fetch($this->getPdoResultType($result_type));
            return $records;
        } catch (\PDOException $e) {
            // Log or echo the error message
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }
    private function getPdoResultType($result_type)
    {
        switch ($result_type) {
            case DB_OBJECT: {
                    $fetchMode = \PDO::FETCH_OBJ;
                    break;
                }
            case DB_ARRAY: {
                    $fetchMode = \PDO::FETCH_BOTH;
                    break;
                }
            case DB_ASSOC: {
                    $fetchMode = \PDO::FETCH_ASSOC;
                    break;
                }
            case DB_ROW: {
                    $fetchMode = \PDO::FETCH_NUM;
                    break;
                }
            default: {
                    $fetchMode = \PDO::FETCH_OBJ;
                }
        }
        return $fetchMode;
    }
    public function update($data, $where = null)
    {
        $this->params = [];
        $this->query = "UPDATE " . $this->table . " SET ";
        foreach ($data as $column => $value) {
            $this->query .= "$column = ?, ";
            $this->params[] = $value;
        }
        $this->query = substr($this->query, 0, -2);
        $where_str = null;
        if ($where == null) {
            $where_str = $this->where;
        } else if (is_array($where)) {
            $where_str = " WHERE " . $this->build_where($where);
        } else {
            $where_str = " WHERE " . $where;
        }
        if ($where_str != null) {
            $this->query .= $where_str;
            $stmt = $this->pdo->prepare($this->query);
            $params = $this->params;
            $this->params = [];
            return $stmt->execute($params);
        } else {
            return false;
        }
    }
    public function whereconditiondatatable($str)
    {
        $this->query .= " WHERE  $str ";
        // echo   $this->query;
        //exit;
        return $this;
    }
    public function whereconditionarchieves($str)
    {
        $this->query .= " WHERE  $str";
        // echo   $this->query;
        //  exit;
        return $this;
    }
    public function delete($id = 0)
    {
        $this->params = [];
        $where_str = null;
        if ($id == 0 || $id == null) {
            $where_str = $this->where;
        } else {
            $where_str = "WHERE {$this->primary_key} = ?";
            $this->params[] = $id;
        }
        if ($where_str != null) {
            $this->query = "DELETE FROM {$this->table} $where_str;";
            $stmt = $this->pdo->prepare($this->query);
            $params = $this->params;
            $this->params = [];
            return $stmt->execute($params);
        } else {
            return false;
        }
    }
    //New functions From New File on 03 oct 2023 by stalin
    public function wherecondition($str)
    {
        $this->query .= " AND   $str";
        //echo   $this->query;
        return $this;
    }
    public function where_between($where = null)
    {
        $where_string = null;
        if (is_array($where)) {
            $where_string .= $this->build_where($where);
        } else {
            $where_string .= $where;
        }
        if ($where_string != null) {
            $this->query .= " AND " . $where_string;
        }
        return $this;
    }
    public function limitpostgres($page_no = null)
    {
        // $page_no  = ((int)$page_no  == 0) ? 1 : $page_no;
        // $starting_index = ($page_no - 1) * $rows_per_page;
        $this->query .= " LIMIT  $page_no";
        // echo $this->query;
        return $this;
    }
    public function where_in($column_name, $data)
    {
        $columns_string = "'" . implode("', '", $data) . "'";
        $this->query .= " AND " . $column_name . " IN( $columns_string)";
        // echo $this->query;
        return $this;
    }
    public function updateRawQuery($tableName, $data, $where = null)
    {
        // $this->query = "UPDATE " . $tableName . " SET ";
        // foreach ($data as $column => $value) {
        //     $this->query .= $this->quote($column) . "=" . $this->safe_str($value) . ", ";
        // }
        // $this->query = substr($this->query, 0, -2);
        // $where_str = null;
        // if ($where ==  null) {
        //     $where_str = $this->where;
        // } else if (is_array($where)) {
        //     $where_str = " WHERE " . $this->build_where($where);
        // } else {
        //     $where_str =  " WHERE " . $where;
        // }
        // if ($where_str != null) {
        //     $this->query  .= $where_str;
        //     return $this->execute($this->query);
        // } else {
        //     return false;
        // }
        $this->params = [];
        $this->query = "UPDATE " . $tableName . " SET ";
        foreach ($data as $column => $value) {
            $this->query .= "$column = ?, ";
            $this->params[] = $value;
        }
        $this->query = substr($this->query, 0, -2);
        $where_str = null;
        if ($where == null) {
            $where_str = $this->where;
        } else if (is_array($where)) {
            $where_str = " WHERE " . $this->build_where($where);
        } else {
            $where_str = " WHERE " . $where;
        }
        if ($where_str != null) {
            $this->query .= $where_str;
            $stmt = $this->pdo->prepare($this->query);
            $params = $this->params;
            $this->params = [];
            return $stmt->execute($params);
        } else {
            return false;
        }
    }
    //New functions From New File on 03 oct 2023 by stalin
    public function execute($fetch_type = DB_OBJECT)
    {
        try {
            $stmt = $this->pdo->prepare($this->query);
            $stmt->execute($this->params);
            $this->params = [];
            $this->last_query = $this->interpolateQuery($this->query, $this->params);
            return $stmt->fetchAll($this->getPdoResultType($fetch_type));
        } catch (\PDOException $e) {
            // Handle the exception, e.g., log the error or return a specific value indicating failure.
            return false;
        }
    }
    private function interpolateQuery($query, $params)
    {
        $keys = array();
        $values = $params;
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/:' . $key . '/';
            } else {
                $keys[] = '/[?]/';
            }
            if (is_string($value)) {
                $values[$key] = "'" . $value . "'";
            }
            if (is_array($value)) {
                $values[$key] = implode(',', $value);
            }
            if (is_null($value)) {
                $values[$key] = 'NULL';
            }
        }
        return preg_replace($keys, $values, $query, 1, $count);
    }
}
