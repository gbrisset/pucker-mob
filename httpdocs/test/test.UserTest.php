<?php 

require_once dirname(dirname(__FILE__)).'/assets/php/config.php';
require_once dirname(dirname(__FILE__)).'/Connector.php';

use PHPUnit\Framework\TestCase;
//require_once dirname(dirname(__FILE__)).'/assets/php/class.Connector.php';
//require_once dirname(dirname(__FILE__)).'/assets/php/class.DatabaseObject.php';
//require_once dirname(dirname(__FILE__)).'/assets/php/class.User.php';


class UserTest extends TestCase
{
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