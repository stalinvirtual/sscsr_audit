<?php
/**
 * User model
 */
namespace App\Models;
use App\System\DB\DB;
use App\Helpers\functions;
use App\Helpers\Helpers;
class Users extends DB
{
    private $table_name = 'accounts';
    public function __construct()
    {
        parent::__construct('accounts', 'user_id');
    }
    public function getUser($id = NULL)
    {
        if ($id == null) { // if id is null then get the user from session
            return $_SESSION['user'];
        }
    }
    public function getUsers()
    {
    }
    public function getUserRole($id)
    {
        $user = $this->select("user_role")->from("user_role")->where(['id' => $id, 'status' => 'true']);
        return $user->user_role;
    }
    public function authenticate($username, $enteredPassword)
    {
        $username = Helpers::cleanData($username);
        $userData = $this->select('accounts.username as username, accounts.password as hashedpassword, 
        accounts.user_id as userid, roles.role_id as roleid, roles.role_name as rolename')
            ->from("accounts")
            ->join("roles", "accounts.user_role_id = roles.role_id", "JOIN")
            ->where(['accounts.username' => $username])
            ->get_one(DB_ASSOC);
        $userData = (array) $userData;
        $cnt = count($userData);
        if ($userData && $cnt > 1) {
            $hashedPassword = $userData['hashedpassword'];
            if (password_verify($enteredPassword, $hashedPassword)) {
                unset($$hashedPassword);
                $_SESSION['user'] = $userData;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    //     public function authenticate($username, $Password)
    //     {
    //         $username = Helpers::cleanData($username);
    //         $md5Password = Helpers::cleanData($Password);
    //         $fetch_row  = $this->select('accounts.username as username, accounts.password as cpassword, 
    //  accounts.user_id as userid, roles.role_id as roleid, roles.role_name as rolename')
    //             ->from("accounts")
    //             ->join("roles ", "accounts.user_role_id = roles.role_id", "JOIN")
    //             ->where(['accounts.username' => $username])
    //             ->get_one(DB_ASSOC);
    //         $user = (array) $fetch_row;
    //         $hash_password = $user['cpassword'];
    //         if(password_verify($md5Password, $hash_password)){
    //             $cnt = count($user);
    //         if ($user && $cnt > 1) {
    //             $data = [
    //                 'last_login' => date('Y-m-d H:i:s'),
    //             ];
    //             $this->updatelastlogin($user['userid']);
    //             unset($user['cpassword']);
    //             $_SESSION['user'] = $user;
    //             return true;
    //         } else {
    //             return false;
    //         }
    //             return true;
    //         }else{
    //             return false;
    //         }
    //     }
    // chedk the user is admin or not
    public function is_superadmin()
    {
        $user = $this->getUser();
        return $user['roleid'] == 1;
    }
    public function is_admin()
    {
        $user = $this->getUser();
        return $user['roleid'] == 2;
    }
    public function is_uploader()
    {
        $user = $this->getUser();
        return $user['roleid'] == 3;
    }
    public function is_publisher()
    {
        $user = $this->getUser();
        return $user['roleid'] == 4;
    }
    public function loginStatus($usr_name)
    {
        $data = ['last_login' => date('Y-m-d H:i:s'), 'status' => 'true'];
        return $this->update($data, ['username' => $usr_name]);
    }
    public function updatelastlogin($id)
    {
        $date = date('Y-m-d H:i:s');
        $menu_data = [
            'last_login' => $date,
            'status'     => 'true'
        ];
        return $this->update($menu_data, ['user_id' => $id]);
    }
    public function getRolesList()
    {
        $fetch_all =  $this->select()
            ->from("roles ")
            ->where('role_id != 1 and role_id != 2')
            ->get_list();
        return $fetch_all;
    }
}
