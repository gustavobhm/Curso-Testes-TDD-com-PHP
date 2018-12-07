<?php

use PHPUnit\Framework\TestCase;

require "Usuario.php";
require "Lance.php";
require "FiltroDeLances.php";

class FiltroDeLancesTest extends TestCase {

    public function testDeveSelecionarLancesEntre1000E3000() {
        $joao = new Usuario("Joao");

        $filtro = new FiltroDeLances();
        $lances = [];
        $lances[] = new Lance($joao,2000);
        $lances[] = new Lance($joao,1000);
        $lances[] = new Lance($joao,3000);
        $lances[] = new Lance($joao,800);

        $resultado = $filtro->filtra($lances);

        $this->assertEquals(1, count($resultado));
        $this->assertEquals(2000, $resultado[0]->getValor(), 0.00001);
    }

    public function testDeveSelecionarLancesEntre500E700() {
        $joao = new Usuario("Joao");

        $filtro = new FiltroDeLances();
        $lances = [];
        $lances[] = new Lance($joao,600);
        $lances[] = new Lance($joao,500);
        $lances[] = new Lance($joao,700);
        $lances[] = new Lance($joao,800);

        $resultado = $filtro->filtra($lances);
        $this->assertEquals(1, count($resultado));
        $this->assertEquals(600, $resultado[0]->getValor(), 0.00001);
    }

    public function testDeveSelecionarLancesMaioresQue5000() 
    {
        $joao = new Usuario("Joao");

        $filtro = new FiltroDeLances();

        $lances = [];
        $lances[] = new Lance($joao, 10000);
        $lances[] = new Lance($joao, 800);

        $resultado = $filtro->filtra($lances);

        $this->assertEquals(1, count($resultado));
        $this->assertEquals(10000, $resultado[0]->getValor(), 0.00001);
    }

    public function testDeveEliminarMenoresQue500() 
    {
        $joao = new Usuario("Joao");

        $filtro = new FiltroDeLances();

        $lances = [];
        $lances[] = new Lance($joao, 400);
        $lances[] = new Lance($joao, 300);

        $resultado = $filtro->filtra($lances);
        $this->assertEquals(0, count($resultado));
    }

    public function testDeveEliminarEntre3000E5000() 
    {
        $joao = new Usuario("Joao");

        $filtro = new FiltroDeLances();

        $lances = [];
        $lances[] = new Lance($joao, 4000);
        $lances[] = new Lance($joao, 3500);

        $resultado = $filtro->filtra($lances);
        $this->assertEquals(0,count($resultado));
    }    
}

?>
