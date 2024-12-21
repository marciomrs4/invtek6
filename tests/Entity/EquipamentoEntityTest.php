<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Equipamento;

class EquipamentoEntityTest extends TestCase
{
    private Equipamento $equipamento;
    
    public function setUp(): void 
    {
        $this->equipamento = new Equipamento();
    }
    
    public function testMethodReturnType(): void
    {
        $descricao = 'descricao';
        $this->equipamento->setDescricao($descricao);
        
        $this->assertEquals($descricao, $this->equipamento->getDescricao());
        
    }
}
