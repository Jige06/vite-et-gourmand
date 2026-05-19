<?php

class LegalController
{

    public function showCgv()
    {
        require_once(__DIR__ . '/../views/legal/cgv.php');
    }

    public function showMentionsLegales()
    {
        require_once(__DIR__ . '/../views/legal/mentions-legales.php');

    }
}