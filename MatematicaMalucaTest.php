<?php

use PHPUnit\Framework\TestCase;

require "MatematicaMaluca.php";

class MatematicaMalucaTest extends TestCase  
{
    public function testDeveMultiplicarNumerosMaioresQue30() 
    {
        $matematica = new MatematicaMaluca();
        $this->assertEquals(50*4, $matematica->contaMaluca(50));
    }

    public function testDeveMultiplicarNumerosMaioresQue10EMenoresQue30() 
    {
        $matematica = new MatematicaMaluca();
        $this->assertEquals(20*3, $matematica->contaMaluca(20));
    }

    public function testDeveMultiplicarNumerosMenoresQue10() 
    {
        $matematica = new MatematicaMaluca();
        $this->assertEquals(5*2, $matematica->contaMaluca(5));
    }
}

?>
