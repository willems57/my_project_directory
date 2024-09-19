<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

  class LuckyController
  {
   #[Route('/lucky/number')]
      public function number(): Response
    {  
       return $this->number(1, 100);
        // this looks exactly the same
    } 
  }