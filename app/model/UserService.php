<?php


namespace App\model;


use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use PDO;

class UserService
{
    private$pdo,$auth, $database, $queryFactory;
//Constructor:
    public function __construct(PDO $pdo,Auth $auth, QueryBuilder $database,QueryFactory $queryFactory)
    {    $this->pdo = $pdo;
        $this->auth = $auth;
        $this->database=$database;
        $this->queryFactory = $queryFactory;
    }

//Method of Get One Massive from Different DatabaseTable:
    public function getOneFromTables($id){
        $select = $this->queryFactory->newSelect();
        $select
            ->cols(['*'])
            -> from('users')
            -> join(
                'INNER',
                'users_information as info',
                'users.id = info.user_id'
            )
            ->join(
                'INNER',
                'users_links as links',
                'users.id = links.user_id'
            )
            ->where('users.id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
//MEthod of Get All Massive from Different DatabaseTable:
    public function getAllFromTables(){
        $select = $this->queryFactory->newSelect();
        $select
            ->cols(['*'])
            -> from('users')
            -> join(
                'INNER',
                'users_information as info',
                'users.id = info.user_id'
            )
            ->join(
                'INNER',
                'users_links as links',
                'users.id = links.user_id'
            );
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
//Method of Change email and password:
    public function changeSecurity($id,$data){

        $currentUser=$this->database->find('users',$id); //fetch current User from db
        $newUser=$this->database->getByEmail('users',$_POST['email']); //fetch new user by his email

        if($newUser['email']==$currentUser['email']){
            $this->database->update('users',$data,'id=:id',$id);

            flash()->success('логин и пароль профиля успешно обновлены');
            redirect('/home');
        }else{
            if(!empty($newUser)){
                flash()->error('Этот эл. адрес уже занят другим пользователем.');
                redirect('/security'.$id);
            }else{
                $this->database->update('users',$data,'id=:id',$id);
                flash()->success('логин и пароль профиля успешно обновлены');
                redirect('/home');
            }
        }
    }
//Method of Delete user by id:
    public function deleteUserbyID($id){
        $userId=$this->database->getByUserId('users_information',$id);


        $this->database->delete('users','id=:id',$id);
        $this->database->delete('users_information','user_id=:id',$id);
        $this->database->delete('users_links','user_id=:id',$id);
        $image=$userId['avatar'];
        if(!empty($image)){
            unlink("uploads/$image");
        }
        flash()->success('один из пользователей успешно удален');

    }


}