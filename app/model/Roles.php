<?php
namespace App\model;


use Delight\Auth\Role;

final class Roles{

const ADMIN =Role::ADMIN;
const USER=Role::AUTHOR;

    public static function getRoles()
    {
        return [
            [
                'id'    =>  self::USER,
                'title' =>  'Обычный пользователь'
            ],
            [
                'id'    =>  self::ADMIN,
                'title' =>  'Администратор'
            ]
        ];
    }

    public static function getRole($key)
    {
        foreach(self::getRoles() as $role) {
            if($role['id'] == $key) {
                return $role['title'];
            }
        }
    }

}