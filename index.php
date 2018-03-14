<?php
namespace App;

require_once __DIR__ . "/vendor/autoload.php";

use App\Controllers\TicketController;

if (putenv("GOOGLE_APPLICATION_CREDENTIALS="+__DIR__+"/chave.json")){
    echo "deu certo\n";
}

$ticketReader = new TicketController();
$ticketReader->readTickets();
$ticketReader->loadDataBase();

?>