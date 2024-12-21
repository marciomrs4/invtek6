<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class EnderecoIpControllerTest extends WebTestCase
{
    
    private $cliente;
    private $user;
    private $enderecoIp;
    
    public function setUp(): void
    {
        $this->cliente = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->user = $userRepository->findOneByUsername('admin');
        
        $manager = static::getContainer()->get('doctrine')->getManager();
        $repository = $manager->getRepository(\App\Entity\EnderecoIp::class);
        
        $this->enderecoIp = $repository->findOneBy([]);
    
        
    }


    public function testAccessIndexEnderecoIp(): void
    {
        
        $this->cliente->loginUser($this->user);
        
        
        $crawler = $this->cliente->request('GET', '/cadastro/enderecoip/');
        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Endereço IP');
    }
    
    public function testAccessNewEnderecoIp(): void
    {  
        $this->cliente->loginUser($this->user);
        $crawler = $this->cliente->request('GET', '/cadastro/enderecoip/new');
        $this->assertResponseIsSuccessful();
        
    }
    
    
    public function testAccessShowEnderecoIp(): void
    {  
        $this->cliente->loginUser($this->user);
            
        $crawler = $this->cliente->request('GET', "/cadastro/enderecoip/{$this->enderecoIp->getId()}");
        $this->assertResponseIsSuccessful();
        
    }
    
    
    public function testAccessEditEnderecoIp(): void
    {  
        $this->cliente->loginUser($this->user);
            
        $crawler = $this->cliente->request('GET', "/cadastro/enderecoip/{$this->enderecoIp->getId()}/edit");
        $this->assertResponseIsSuccessful();
        
    }
    
}
