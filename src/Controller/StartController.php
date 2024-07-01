<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StartController extends AbstractController
{
    #[Route('/', name: 'start')]
    public function list(): Response
    {
        return new Response('ᛖᛖᚾ ᛞᚹᚨᚨᛊ ᛗᛖᛖᚾᛏ ᚨᛚᛚᛖᛊ ᛏᛖ ᚹᛖᛏᛖᚾ ᚨᛚᛊ ᚺᛁᛃ ᛊᛏᛁᛚ ᛟᛈ ᛉᛁᛃᚾ ᛈᛚᛖᚲ ᛉᛁᛏ. ᚺᛁᛃ ᚹᛖᛖᛏ ᚾᛁᛖᛏ ᚹᚨᛏ ᚺᛁᛃ ᛗᛟᛖᛏ ᛉᛖᚷᚷᛖᚾ ᚨᛚᛊ ᚺᛁᛃ ᛟᛈ ᛞᛖ ᛈᚱᛟᛖᚠ ᚹᛟᚱᛞᛏ ᚷᛖᛊᛏᛖᛚᛞ.');
    }
}