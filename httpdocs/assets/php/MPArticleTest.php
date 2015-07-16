<?php
class MPArticleTest extends PHPUnit_Framework_TestCase
{
    public function testPushAndPop()
    {
        $stack = array();
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));

        //$this->assertTrue(FALSE);
    }

    public function testgetArticlesList(){

        include_once('config.php');

        $this->assetEquals( NULL, $config ); 
    //	$articles = new MPArticle( $config );
    }
}
?>