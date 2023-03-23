<?php

namespace App\Service;

use App\Entity\Hospedagem;
use App\Entity\Recibo;
use App\Repository\ReciboRepository;

class ReciboService 
{

    public function __construct(private ReciboRepository $reciboRepository)
    { 
    }

    public function createRecibo(Hospedagem $hospedagem): Recibo
    {
      $recibo = new Recibo();
      $recibo->setHospedagem($hospedagem);
      $recibo->setIntervaloTempo();
      $recibo->setPrecoEstadia();
      $recibo->setPrecoServicos();
      $recibo->setPrecoTotal();
      $recibo->setDataFechamento();

      $this->reciboRepository->save($recibo, true);

      return $recibo;
    }
}