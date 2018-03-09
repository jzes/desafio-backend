<?php
class ticketReader{

    public $ticketsFilePath = "tickets.json";
    public $tickets;

    function readTickets(){
        $this->tickets = json_decode(file_get_contents($this->ticketsFilePath, "r"));
        return $this->tickets;
    }

    function addHumorToInteractions(){
        foreach ($this->tickets as &$ticket){
            //var_dump($ticket);
            echo "------------------------------------\n\n";
            foreach ($ticket->Interactions as &$interaction){
                echo "+++++\n";
                $interaction->humor = "teste";
                var_dump($interaction);
            }
        }
    }
}

$ticketReader = new ticketReader;
$ticketReader->readTickets();
$ticketReader->addHumorToInteractions();



