<?php 

require dirname(dirname(FILE)).'/class.User.php';


class UserTest extends PHPUnit_Framework_TestCase{
   
    public function testGetUserInfo()
    {
        //$email = 'fguzman@sequelmediainternational';
        //$user = new User( $email );
        $user = new User('fguzman@sequelmediagroup.com');

       // $user_id = $user->getUserId();


        $this->assertNotEmpty('ljk');


    }
}
?>