<?php

namespace App\DAO\VeroCard\AdminUsers;

use App\DAO\VeroCard\Connection;
use App\Models\AdminUsersModel;

class AdminUsersDAO extends Connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllUsers(string $sub): array
    {

        $statement = $this->pdo
            ->query("SELECT * from usuarios_truck_pag where id != $sub ")
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $statement;
    }

    public function CreateUsers(AdminUsersModel $usersModel)
    {

        $statement = $this->pdo
            ->prepare("INSERT INTO usuarios_truck_pag (nome , email , senha , admin) VALUES (:nome , :email , :senha, :admin);");

        $statement->execute([
            'nome' => $usersModel->getNome(),
            'email' => $usersModel->getEmail(),
            'senha' => $usersModel->getSenha(),
            'admin' => $usersModel->getAdmin()
        ]);
    }

    public function UpdateUsers(AdminUsersModel $usersModel)
    {

        $statement = $this->pdo
            ->prepare("UPDATE usuarios_truck_pag SET nome=:nome,  email=:email, senha=:senha, admin=:admin  WHERE id = :id;");

        $statement->execute([
            'id' => $usersModel->getId(),
            'nome' => $usersModel->getNome(),
            'email' => $usersModel->getEmail(),
            'senha' => $usersModel->getSenha(),
            'admin' => $usersModel->getAdmin()
        ]);
    }

    public function DeleteUsers($idUser)
    {

        $deleteTokenLogs = $this->pdo
            ->prepare("DELETE from tokens_truck_pag WHERE usuarios_id = :idUser;");

        $deleteTokenLogs->execute([
            'idUser' => $idUser
        ]);

        $deleteUser = $this->pdo
            ->prepare("DELETE from usuarios_truck_pag WHERE id = :idUser;");

        $deleteUser->execute([
            'idUser' => $idUser
        ]);
    }

    public function emailVerificationWhere(string $email)
    {

        $statement = $this->pdo
            ->query("SELECT * FROM usuarios_truck_pag WHERE email = '$email';")->fetchAll(\PDO::FETCH_ASSOC);

        if (count($statement) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function UserSearchEmail(string $email)
    {

        $statement = $this->pdo
            ->query("SELECT * FROM usuarios_truck_pag WHERE email = '$email';")->fetchAll(\PDO::FETCH_ASSOC);

        return $statement;
    }
}
