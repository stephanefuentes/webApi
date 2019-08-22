<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Services\ResteService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResteTest extends WebTestCase
{
    // public function testIndex()
    // {
    //     $client = static::createClient();

    //     $crawler = $client->request('GET', '/');

    //     $this->assertEquals(200, $client->getResponse()->getStatusCode());
    //     $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    // }


    private $rs ; 
    
    // Initialisation des données de tests
    // fonction appelé avant chaque test
    protected function setUp( ResteService $rs )
    {
        $this->rs = $rs;
    }
    
    
    public function testIndex()
    {
       // execution des tests
        $result =  $rs->monnaie(12) ; // [ 1,0,1]
        $this->assertTrue( $result == [1,0,1] , 'monnaie a pas fonctionné' );
        
        $result =  $rs->monnaie(17) ; // [ 1,0,1]
        $this->assertTrue( $result == [1,1,1] );
        
        
    }
    
    // fonction executée apres les tests
    protected function tearDown()
    {
        
    }
    
}








}
