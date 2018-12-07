<?php

use PHPUnit\Framework\TestCase;

require "Usuario.php";
require "Lance.php";
require "Leilao.php";

class LeilaoTest extends TestCase {

    public function testNaoDeveAceitarDoisLancesSeguidosDoMesmoUsuario() 
    {
        $leilao = new Leilao("Macbook Pro 15");

        $steveJobs = new Usuario("Steve Jobs");

        $leilao->propoe(new Lance($steveJobs, 2000));
        $leilao->propoe(new Lance($steveJobs, 3000));

        $this->assertEquals(1, count($leilao->getLances()));
        $this->assertEquals(2000, $leilao->getLances()[0]->getValor(), 0.00001);
    }

    public function testNaoDeveAceitarMaisDoQue5LancesDeUmMesmoUsuario() 
    {
        $leilao = new Leilao("Macbook Pro 15");

        $steveJobs = new Usuario("Steve Jobs");
        $billGates = new Usuario("Bill Gates");

        $leilao->propoe( new Lance( $steveJobs, 2000) );
        $leilao->propoe( new Lance( $billGates, 3000) );
        $leilao->propoe( new Lance( $steveJobs, 3000) );
        $leilao->propoe( new Lance( $billGates, 3000) );
        $leilao->propoe( new Lance( $steveJobs, 4000) );
        $leilao->propoe( new Lance( $billGates, 3000) );
        $leilao->propoe( new Lance( $steveJobs, 5000) );
        $leilao->propoe( new Lance( $billGates, 3000) );
        $leilao->propoe( new Lance( $steveJobs, 6000) );
        $leilao->propoe( new Lance( $billGates,  999) );
        $leilao->propoe( new Lance( $steveJobs, 7000) );

        $this->assertEquals(10, count($leilao->getLances()));

        $ultimo = count($leilao->getLances())- 1;

        $this->assertEquals(999, $leilao->getLances()[$ultimo]->getValor(), 0.00001);
    }

    public function testDeveDobrarOUltimoLanceDado() 
    {
        $leilao = new Leilao("Macbook Pro 15");
        $steveJobs = new Usuario("Steve Jobs");
        $billGates = new Usuario("Bill Gates");

        $leilao->propoe(new Lance($steveJobs, 2000));
        $leilao->propoe(new Lance($billGates, 3000));
        $leilao->dobraLance($steveJobs);

        $this->assertEquals(4000, $leilao->getLances()[2]->getValor(), 0.00001);
    }

    public function testNaoDeveDobrarCasoNaoHajaLanceAnterior() 
    {
        $leilao = new Leilao("Macbook Pro 15");
        $steveJobs = new Usuario("Steve Jobs");

        $leilao->dobraLance($steveJobs);

        $this->assertEquals(0, count($leilao->getLances()));
    }    

}

?>
