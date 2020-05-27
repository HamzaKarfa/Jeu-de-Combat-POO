<?php

$db = new PDO('mysql:host=127.0.0.1;dbname=tp_jeu_de_combat_poo', 'root', '');
// On émet une alerte à chaque fois qu'une requête a échoué.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); 