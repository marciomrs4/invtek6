<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class EquipamentoTest extends WebTestCase
{
    
    private $cliente;
    private $user;

    
    public function setUp(): void
    {
        $this->cliente = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->user = $userRepository->findOneByUsername('admin');
    }


    
    public function testAccessIndexEquipamentoSucess(): void
    {
        $this->cliente->loginUser($this->user);
        
        $crawler = $this->cliente->request('GET', '/cadastro/equipamento/');

        $this->assertResponseIsSuccessful();
   
    }
    
    public function testAccessNewEquipamentoSucess(): void
    {
        $this->cliente->loginUser($this->user);
        
        $crawler = $this->cliente->request('GET', '/cadastro/equipamento/new');

        $this->assertResponseIsSuccessful();
   
    }
    
    public function testAccessIndexEquipamentoContains(): void
    {
        $this->cliente->loginUser($this->user);
        
        $crawler = $this->cliente->request('GET', '/cadastro/equipamento/');

        $this->assertAnySelectorTextContains('h1', 'Equipamento Listar');
        
    }
}
