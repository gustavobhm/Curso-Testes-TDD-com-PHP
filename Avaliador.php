<?php

class Avaliador {

    private $maiorDeTodos = -INF;
    private $menorDeTodos = INF;
    private $maiores;

    public function avalia(Leilao $leilao) {

        if(count($leilao->getLances()) == 0){
            throw new InvalidArgumentException("Um leilão preciasa ter pelo menos 1 lance");
        }

        foreach($leilao->getLances() as $lance) {
            if($lance->getValor() > $this->maiorDeTodos)
                $this->maiorDeTodos = $lance->getValor();
            if($lance->getValor() < $this->menorDeTodos)
                $this->menorDeTodos = $lance->getValor();
        }

        $this->pegaOsMaioresNo($leilao);
    }

    public function pegaOsMaioresNo(Leilao $leilao) {

        $lances = $leilao->getLances();
        usort($lances,function ($a,$b) {
            if($a->getValor() == $b->getValor()) return 0;
            return ($a->getValor() < $b->getValor()) ? 1 : -1;
        });

        $this->maiores = array_slice($lances, 0,3);
    }

    public function getTresMaiores() {
        return $this->maiores;
    }

    public function getMaiorLance() {
        return $this->maiorDeTodos;
    }

    public function getMenorLance() {
        return $this->menorDeTodos;
    }
}

?>
