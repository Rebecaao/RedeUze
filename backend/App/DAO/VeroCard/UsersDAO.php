<?php

namespace App\DAO\VeroCard;
use App\Models\UsersModel;

class UsersDAO extends Connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserbyEmail(string $email) : ?UsersModel
    {
        $statement = $this->pdo
            ->prepare('SELECT id ,nome, email, senha FROM usuarios_vero_card WHERE email = :email;');

        $statement->bindParam('email', $email);

        $statement->execute();

        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (count($users) === 0) 
            return null;

            $usuario = new UsersModel();

            $usuario->
            setId($users[0]['id'])
            ->setNome($users[0]['nome'])
            ->setEmail($users[0]['email'])
            ->setSenha($users[0]['senha']);

                
            return $usuario;  
        
       
    }

}
?>