<?php


class Action
{

    private $db;

    /**
     * Action constructor.
     * @param $action
     */
    public function __construct($action)
    {
        $login = htmlspecialchars($_POST['login'], ENT_QUOTES);
        $pwd = htmlspecialchars($_POST['pwd'], ENT_QUOTES);
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
        $fio = htmlspecialchars($_POST['fio'], ENT_QUOTES);

        $this->db = MySqlDB::getInstance(DB_HOST, DB_BASE, DB_USER, DB_PWD);
        session_start();

        switch ($action) {
            case 'auth':
                $this->auth($login, $pwd);
                break;
            case 'logout':
                $this->logout();
                break;
            case 'create':
                $this->createUser($login, $pwd, $email, $fio);
                break;
            case 'edit':
                $this->changeUser($login, $pwd, $email, $fio);
                break;
            default:
                http_response_code(405);
        }
    }

    private function auth($login, $pwd)
    {
        $userArray = $this->db->select('user', ['id', 'fio', 'email', 'pwd'],
            "where login like :login", ['login' => $login]);
        $id = -1;
        $user = new User();
        $user->login = $login;
        if (!empty($userArray) && password_verify($pwd, $userArray[0]["pwd"])) {
            $user->id = $userArray[0]["id"];
            $user->fio = $userArray[0]['fio'];
            $user->email = $userArray[0]['email'];
            $_SESSION['user'] = $user->id;
        } else {
            $user->id = -1;
        }
        $this->returnEcho($user);
    }

    private function logout()
    {
        session_destroy();
        $_SESSION['user'] = -1;
        unset($_SESSION['user']);
        session_unset();
        $this->returnEcho((object)array('msg' => 'logout'));
    }

    private function createUser($login, $pwd, $email, $fio)
    {
        $user = new User();
        $user->login = $login;
        $user->fio = $fio;
        $user->email = $email;
        $return = $this->db->insert(['login', 'pwd', 'fio', 'email'],
            'user', [$login, password_hash($pwd, PASSWORD_DEFAULT), $fio, $email]);
        if ($return['insertId'] > 0)
            $user->id = $return['insertId'];
        else
            $user->id = -1;
        $_SESSION['user'] = $user->id;
        $this->returnEcho($user);
    }

    private function changeUser($login, $pwd, $email, $fio)
    {
        if(!isset($_SESSION['user']) || $_SESSION['user']<0){
            http_response_code(401);
            die();
        }
        $user = new User();
        $user->login = $login;
        $user->fio = $fio;
        $user->email = $email;
        $return = $this->db->update(['login', 'pwd', 'fio', 'email'],
            'user', [$login, password_hash($pwd, PASSWORD_DEFAULT), $fio, $email],
            $_SESSION['user']);
        if ($return['rows'] > 0)
            $user->id = $_SESSION['user'];
        else
            $user->id = -1;
        $this->returnEcho($user);
    }

    private function returnEcho($msg)
    {
        header("Content-type:application/json");
        echo json_encode($msg);
    }
}