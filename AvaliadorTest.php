<?php

use PHPUnit\Framework\TestCase;

require "Usuario.php";
require "Lance.php";
require "Leilao.php";
require "Avaliador.php";
require "CriadorDeLeilao.php";

class AvaliadorTest extends TestCase {

    private $leiloeiro;
    private $joao;
    private $maria;
    private $renan;
    private $jose;
    private $felipe;

    public function setUp() {
        var_dump("setUp");
        $this->leiloeiro = new Avaliador();
        $this->joao = new Usuario("João");
        $this->maria = new Usuario("Maria");
        $this->renan = new Usuario("Renan");
        $this->jose = new Usuario("José");
        $this->felipe = new Usuario("Felipe");
    }

    public static function setUpBeforeClass() {
        var_dump("setUpBeforeClass");
    }

    public function testAceitaLeilaoEmOrdemCrescente() {

        $criador = new CriadorDeLeilao();
        $leilao = $criador->para("Playstation 3 Novo")
            ->lance($this->joao, 250)
            ->lance($this->renan, 300.0)
            ->lance($this->felipe, 400.0)
            ->constroi();        

        $this->leiloeiro->avalia($leilao);

        $maiorEsperado = 400;
        $menorEsperado = 250;

        $this->assertEquals($maiorEsperado,$this->leiloeiro->getMaiorLance());
        $this->assertEquals($menorEsperado,$this->leiloeiro->getMenorLance());

    }

    public function testAceitaLeilaoComUmLance() 
    {

        $criador = new CriadorDeLeilao();
        $leilao = $criador->para("Playstation 3 Novo")
            ->lance($this->joao, 250)
            ->constroi();  

        $this->leiloeiro->avalia($leilao);

        $maiorEsperado  = 250;
        $menorEsperado = 250;

        $this->assertEquals( $this->leiloeiro->getMaiorLance(), $maiorEsperado );
        $this->assertEquals( $this->leiloeiro->getMenorLance(), $menorEsperado );
    }   

    public function testDeveEntenderLeilaoComLancesEmOrdemRandomica() 
    {

        $criador = new CriadorDeLeilao();
        $leilao = $criador->para("Playstation 3 Novo")
            ->lance($this->joao, 200)
            ->lance($this->maria, 400)
            ->lance($this->joao, 120)
            ->lance($this->maria, 700)
            ->lance($this->joao, 630)
            ->lance($this->maria, 230)            
            ->constroi();     

        $this->leiloeiro->avalia($leilao);

        $this->assertEquals(700.0, $this->leiloeiro->getMaiorLance(), 0.0001);
        $this->assertEquals(120.0, $this->leiloeiro->getMenorLance(), 0.0001);
    }    

    public function testDeveEntenderLeilaoComLancesEmOrdemDecrescente() 
    {

        $criador = new CriadorDeLeilao();
        $leilao = $criador->para("Playstation 3 Novo")
            ->lance($this->joao, 400)
            ->lance($this->maria, 300)
            ->lance($this->joao, 200)
            ->lance($this->maria, 100)
            ->constroi();     

        $this->leiloeiro->avalia($leilao);

        $this->assertEquals(400.0, $this->leiloeiro->getMaiorLance(), 0.0001);
        $this->assertEquals(100.0, $this->leiloeiro->getMenorLance(), 0.0001);
    }

    public function testDeveEncontrarOsTresMaioresLances() 
    {

        $criador = new CriadorDeLeilao();
        $leilao = $criador->para("Playstation 3 Novo")
            ->lance($this->joao, 100)
            ->lance($this->maria, 200)
            ->lance($this->joao, 300)
            ->lance($this->maria, 400)
            ->constroi();     

        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getTresMaiores();

        $this->assertEquals(3, count($maiores));
        $this->assertEquals(400, $maiores[0]->getValor(), 0.00001 );
        $this->assertEquals(300, $maiores[1]->getValor(), 0.00001 );
        $this->assertEquals(200, $maiores[2]->getValor(), 0.00001 );
    }

    public function testDeveDevolverTodosLancesCasoNaoHajaNoMinimo3() 
    {

        $criador = new CriadorDeLeilao();
        $leilao = $criador->para("Playstation 3 Novo")
            ->lance($this->joao, 100)
            ->lance($this->maria, 200)
            ->constroi();     

        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getTresMaiores();

        $this->assertEquals(2, count($maiores));
        $this->assertEquals(200, $maiores[0]->getValor(), 0.00001 );
        $this->assertEquals(100, $maiores[1]->getValor(), 0.00001 );
    }

    /**
    * @expectedException InvalidArgumentException
    */
    public function testDeveDevolverListaVaziaCasoNaoHajaLances() 
    {
        $criador = new CriadorDeLeilao();
        $leilao = $criador->para("Playstation 3 Novo")
            ->constroi();     

        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getTresMaiores();

        $this->assertEquals(0, count($maiores));
    }   

    /**
    * @expectedException Exception
    */
    public function testeDeveRecusarLeilaoSemLances(){

        $criador = new CriadorDeLeilao();
        $leilao = $criador->para("Playstation 4")->constroi();     

        $this->leiloeiro->avalia($leilao);

    }

    public function tearDown() {
        var_dump("tearDown");
    }

    public static function tearDownAfterClass() {
        var_dump("tearDownAfterClass");
    }    

}

?>
