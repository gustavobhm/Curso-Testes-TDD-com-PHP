<?php

use PHPUnit\Framework\TestCase;

require "Usuario.php";
require "Lance.php";
require "Leilao.php";
require "Avaliador.php";

class TesteDoAvaliador extends TestCase {

    public function testAceitaLeilaoEmOrdemCrescente() {

        $joao = new Usuario("Joao");
        $renan = new Usuario("Renan");
        $felipe = new Usuario("Felipe");

        $leilao = new Leilao("Playstation 3");

        $leilao->propoe(new Lance($joao,250));
        $leilao->propoe(new Lance($renan,300));
        $leilao->propoe(new Lance($felipe,400));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $maiorEsperado = 400;
        $menorEsperado = 250;

        $this->assertEquals($maiorEsperado,$leiloeiro->getMaiorLance());
        $this->assertEquals($menorEsperado,$leiloeiro->getMenorLance());

    }

    public function testAceitaLeilaoComUmLance() 
    {
        $joao = new Usuario("Joao");

        $leilao = new Leilao("Playstation 3");

        $leilao->propoe(new Lance($joao,250));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $maiorEsperado  = 250;
        $menorEsperado = 250;

        $this->assertEquals( $leiloeiro->getMaiorLance(), $maiorEsperado );
        $this->assertEquals( $leiloeiro->getMenorLance(), $menorEsperado );
    }   

    public function testDeveEntenderLeilaoComLancesEmOrdemRandomica() 
    {
        $joao   = new Usuario("Joao"); 
        $maria  = new Usuario("Maria"); 

        $leilao = new Leilao("Playstation 3 Novo");

        $leilao->propoe( new Lance( $joao , 200.0) );
        $leilao->propoe( new Lance( $maria, 450.0) );
        $leilao->propoe( new Lance( $joao , 120.0) );
        $leilao->propoe( new Lance( $maria, 700.0) );
        $leilao->propoe( new Lance( $joao , 630.0) );
        $leilao->propoe( new Lance( $maria, 230.0) );

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $this->assertEquals(700.0, $leiloeiro->getMaiorLance(), 0.0001);
        $this->assertEquals(120.0, $leiloeiro->getMenorLance(), 0.0001);
    }    

    public function testDeveEntenderLeilaoComLancesEmOrdemDecrescente() 
    {
        $joao     = new Usuario("Joao"); 
        $maria  = new Usuario("Maria"); 

        $leilao = new Leilao("Playstation 3 Novo");

        $leilao->propoe( new Lance($joao , 400.0) );
        $leilao->propoe( new Lance($maria, 300.0) );
        $leilao->propoe( new Lance($joao , 200.0) );
        $leilao->propoe( new Lance($maria, 100.0) );

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $this->assertEquals(400.0, $leiloeiro->getMaiorLance(), 0.0001);
        $this->assertEquals(100.0, $leiloeiro->getMenorLance(), 0.0001);
    }

    public function testDeveEncontrarOsTresMaioresLances() 
    {
        $joao   = new Usuario("João");
        $maria  = new Usuario("Maria");

        $leilao = new Leilao("Playstation 3 Novo");

        $leilao->propoe( new Lance( $joao , 100.0) );
        $leilao->propoe( new Lance( $maria, 200.0) );
        $leilao->propoe( new Lance( $joao , 300.0) );
        $leilao->propoe( new Lance( $maria, 400.0) );

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $maiores = $leiloeiro->getTresMaiores();

        $this->assertEquals(3, count($maiores));
        $this->assertEquals(400, $maiores[0]->getValor(), 0.00001 );
        $this->assertEquals(300, $maiores[1]->getValor(), 0.00001 );
        $this->assertEquals(200, $maiores[2]->getValor(), 0.00001 );
    }

    public function testDeveDevolverTodosLancesCasoNaoHajaNoMinimo3() 
    {
        $joao   = new Usuario("João");
        $maria  = new Usuario("Maria");

        $leilao = new Leilao("Playstation 3 Novo");

        $leilao->propoe( new Lance($joao , 100.0) );
        $leilao->propoe( new Lance($maria, 200.0) );

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $maiores = $leiloeiro->getTresMaiores();

        $this->assertEquals(2, count($maiores));
        $this->assertEquals(200, $maiores[0]->getValor(), 0.00001 );
        $this->assertEquals(100, $maiores[1]->getValor(), 0.00001 );
    }

    public function testDeveDevolverListaVaziaCasoNaoHajaLances() 
    {
        $leilao = new Leilao("Playstation 3 Novo");

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $maiores = $leiloeiro->getTresMaiores();

        $this->assertEquals(0, count($maiores));
    }    

}

?>
