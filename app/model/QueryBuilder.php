<?php
namespace App\model;

use Aura\SqlQuery\QueryFactory;
use PDO;


class QueryBuilder{
    private $pdo, $queryFactory;
//Constructor:
      public function __construct(PDO $pdo,QueryFactory $queryFactory)
    {
        $this->pdo = $pdo;
        $this->queryFactory=$queryFactory;
    }


    public function getAll($table){
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($table,$id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($table,$email)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->where('email = :email')
            ->bindValue('email',$email);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUserId($table,$userId)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->where('user_id = :user_id')
            ->bindValue('user_id',$userId);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_ASSOC);
    }


    public function insert($table, $data)
    {
        $insert = $this->queryFactory->newInsert();

        $insert
            ->into($table)
            ->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
        $name = $insert->getLastInsertIdName('id');
        return $this->pdo->lastInsertId($name);

    }

    public function update($table,$cols,$where,$id){
    $update = $this->queryFactory->newUpdate();
    $update
        ->table($table)
        ->cols($cols)
        ->where($where)
        ->bindValue('id',$id);

    $sth = $this->pdo->prepare($update->getStatement());
    $sth->execute($update->getBindValues());
     }


//Delete method:
    public function delete($table,$where,$id){
        $delete = $this->queryFactory->newDelete();
        $delete
            ->from($table)
            ->where($where)
            ->bindValue('id', $id);
        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }

}