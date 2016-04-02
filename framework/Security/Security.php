<?php
namespace Framework\Security;

class Security {

    public function isAuthenticated()
    {
      return false;
    }

    public function clear(){}

    public function getUserRole()
    {
       return 'ROLE_USER';
    }
    public function setUser($user)
    {
      //($user);
    }
}


 ?>
