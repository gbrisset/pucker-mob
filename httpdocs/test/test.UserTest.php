<?php 

use PHPUnit\Framework\TestCase;
require_once dirname(dirname(__FILE__)).'/assets/php/class.Connector.php';
require_once dirname(dirname(__FILE__)).'/assets/php/class.DatabaseObject.php';
require_once dirname(dirname(__FILE__)).'/assets/php/class.User.php';

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "puckermob_db");
//require_once('../assets/php/config.php');

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