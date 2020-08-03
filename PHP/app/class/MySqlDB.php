<?php

class MySqlDB
{

    private static $instances;
    private $dbLink;

    private function __construct($host, $dbname, $user, $pwd)
    {
        $dsn = "mysql:host=$host;dbname=$dbname";
        $this->dbLink = new PDO($dsn, $user, $pwd);
    }

    /**
     * @param $host
     * @param $dbname
     * @param $user
     * @param $pwd
     * @return mixed
     */
    public static function getInstance($host, $dbname, $user, $pwd)
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static($host, $dbname, $user, $pwd);
        }

        return self::$instances[$cls];
    }

    public function select($table, $fields, $where = '', $param = '')
    {
        $sql = "select " . implode(",", $fields) . " from $table \n";
        if (!empty($where)) {
            $sql .= $where;
        }
//        echo $sql;
        $query = $this->dbLink->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $query->execute($param);
        return $query->fetchAll();
    }

    public function execChange($sql, $fields, $value)
    {
        $param = array_combine(array_map(function ($a) {
            return $a = ':' . $a;
        }, $fields),
            $value);

        $result = array();

        try {
            $query = $this->dbLink->prepare($sql);
            $query->execute($param);
        } catch (Throwable $err) {
            $result['errorInfo'] = $this->dbLink->errorInfo();
            $result['error'] = $err;
        }

        $result['rows'] = $query->rowCount();
        $result['insertId'] = $this->dbLink->lastInsertId();
        $result['errorCode'] = $this->dbLink->errorCode();

        return $result;
    }

    public function insert($fields, $table, $value)
    {
        $sql = "insert into $table (" . implode(",", $fields) . ") values (" .
            implode(",", array_map(function ($a) {
                return $a = ':' . $a;
            }, $fields)) . ")";

        return $this->execChange($sql, $fields, $value);
    }

    public function update(array $fields, string $table, array $value, int $id): array
    {
        $sql = "update $table set " . implode(',',
                array_map(function ($field) {
                    return "$field = :$field";
                }, $fields)) . " where id = $id";

        return $this->execChange($sql, $fields, $value);
    }
}