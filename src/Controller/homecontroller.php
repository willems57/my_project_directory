<?php

namespace App\Controller;

use symfony\component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\route;
class homecontroller
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $number = 125;
       return new response(content:"salut $number");
    }
  
/**
 * @route("/params/{name}", name="name")
 */
  public function params($name)
    {
 return new response (content:"bonjour monsieur : $name");
    }
}