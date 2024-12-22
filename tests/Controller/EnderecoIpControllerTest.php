<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Entity\EnderecoIp;
use App\Entity\StatusIp;
use App\Entity\TipoAcessoIp;

class EnderecoIpControllerTest extends WebTestCase
{
    
    private $cliente;
    private $user;
    private $enderecoIp;
    private EntityManagerInterface $manager;
    
    public function setUp(): void
    {
        $this->cliente = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->user = $userRepository->findOneByUsername('admin');
        
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        
        $statusIp = new StatusIp();
        $statusIp->setNome('Ativo');
        
        $tipoAcessoIp = new TipoAcessoIp();
        $tipoAcessoIp->setNome('Full');

        $this->manager->persist($statusIp);

        $this->manager->persist($tipoAcessoIp);
        
        $this->manager->flush();
                
        $enderecoIp = new EnderecoIp();
        $enderecoIp->setDoPing(false)
                ->setEnderecoIp('192.168.0.1')
                ->setNome('Server')
                ->setStatus($statusIp)
                ->setObservacao('Observacao')
                ->setTipoAcessoIp($tipoAcessoIp);
        
         
        $this->manager->persist($enderecoIp);
        $this->manager->flush();
        
        $repository = $this->manager->getRepository(EnderecoIp::class);
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
        
        $repository = $this->manager->getRepository(EnderecoIp::class);        
       
        foreach ($repository->findAll() as $ip){
            $this->manager->remove($ip);
        }
        $this->manager->flush();
        
    }
    
}
