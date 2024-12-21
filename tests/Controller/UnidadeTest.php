<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Entity\Unidade;
use Doctrine\ORM\EntityManagerInterface;


class UnidadeTest extends WebTestCase
{
    
    private $cliente;
    private $user;
    static $pathUrl = '/cadastro/unidade/';
    private EntityManagerInterface $manager;
    
    public function setUp(): void
    {
        $this->cliente = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->user = $userRepository->findOneByUsername('admin');
        
        $this->manager = static::getContainer()->get('doctrine')->getManager();
    }


    public function testAccessIndexUnidade(): void
    {

        $this->cliente->loginUser($this->user);
        
        $crawler = $this->cliente->request('GET', UnidadeTest::$pathUrl);

        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('h1', 'Unidade');
    }
    
    public function testAccessNewUnidade(): void
    {

        $this->cliente->loginUser($this->user);
        
        $crawler = $this->cliente->request('GET', UnidadeTest::$pathUrl."new");

        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('h1', 'Unidade');
    }
    
    public function testCreateNewAndShowUnidade(): void
    {

        $this->cliente->loginUser($this->user);
        
        $unidade = new Unidade();
        $unidade->setNome('Uma unidade');
        
        $this->manager->persist($unidade);
        $this->manager->flush();
        
        $this->cliente->request('GET', sprintf('%s%s', static::$pathUrl, $unidade->getId()));
        
        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('h1', 'Unidade Mostrar');
        
        $repository = $this->manager->getRepository(Unidade::class);
        foreach ($repository->findAll() as $object) {
            $this->manager->remove($object);
        }

    }
    

    
}
