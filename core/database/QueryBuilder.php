<?php

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function query($sql) 
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function rowCount($sql) {
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->rowCount();
    }

    public function selectAll($table, $where = '')
    {
        $sql = "SELECT * FROM {$table} ";
        if($where !== '') {
            $sql .= " WHERE {$where}";
        }
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectOne($table, $where = '')
    {
        $sql = "SELECT * FROM {$table} ";
        if($where !== '') {
            $sql .= " WHERE {$where}";
        }
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS)[0];
    }

    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        
        try {
            $statement = $this->pdo->prepare($sql);
            // die(var_dump($statement));
            $statement->execute($parameters);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function update($table, $parameters, $where)
    {
        $set = [];
        foreach($parameters as $key => $val) {
            $set[] = $key . '= :' . $key; 
        }
        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s',
            $table,
            implode(', ', $set),
            $where
        );
        
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($table, $where) 
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE %s',
            $table,
            $where
        );
        
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}