<?php 

class TicketReader{

    public $ticketsFilePath = "tickets.json";
    public $tickets;

    function readTickets(){
        $this->tickets = json_decode(file_get_contents($this->ticketsFilePath, "r"));
        return $this->tickets;
    }

    function loadDataBase(){
        $dataBase = new TicketDAO();
        foreach ($this->tickets as &$ticket){
            //var_dump($ticket);
            echo "------------------------------------\n\n";
            $ticket->Complaint = 'false';
            $dataBase->insertTicket($ticket);
            foreach ($ticket->Interactions as &$interaction){
                //echo "+++++\n";
                $interaction->tone = "teste"; //chamar o tone analyser
                $dataBase->insertInteraction($interaction, $ticket->TicketID);
                //var_dump($interaction);
            }
        }
    }
}


class TicketDAO {
    public $connection;
    public $dataBase;
    public $server;
    public $user;
    public $password;

    function __construct(){
        $this->dataBase = "ticketBase";
        $this->server = "localhost";
        $this->user = "applications";
        $this->password = "app@123";
        $this->connection = mysqli_connect($this->server, $this->user, $this->password);
    }
    
    function insertInteraction($interaction, $ticketID){
        $sqlQuery = "INSERT INTO desafio.interaction
        (TicketID,
        Subject,
        Message,
        DateCreate,
        Sender,
        tone)
        VALUES
        ({$ticketID},
        '{$interaction->Subject}',
        '{$interaction->Message}',
        '{$interaction->DateCreate}',
        '{$interaction->Sender}',
        '{$interaction->tone}');";
        echo $sqlQuery;
        $res = mysqli_query($this->connection, $sqlQuery);
        
        if ($res){
            echo "\nRegistro gravado com sucesso\n";
            return;
        }
        var_dump($res);
    }

    function insertTicket($ticket){
        $sqlQuery = "INSERT INTO desafio.ticket
        (TicketID,
        CategoryID,
        CustomerID,
        CustomerName,
        CustomerEmail,
        DateCreate,
        DateUpdate,
        Complaint)
        VALUES
        ({$ticket->TicketID},
        {$ticket->CategoryID},
        {$ticket->CustomerID},
        '{$ticket->CustomerName}',
        '{$ticket->CustomerEmail}',
        '{$ticket->DateCreate}',
        '{$ticket->DateUpdate}',
        {$ticket->Complaint});";    
        
        $res = mysqli_query($this->connection, $sqlQuery);
        
        if ($res){
            echo "\nRegistro gravado com sucesso\n";
            return;
        }
        var_dump($res);
    }
}


$ticketReader = new ticketReader;
$ticketReader->readTickets();
$ticketReader->loadDataBase();



