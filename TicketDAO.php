<?php

namespace ticketClassifier\DAO;

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
    
    function insertTicket($ticket){
        $res = mysqli_query($this->connection, "INSERT INTO desafio.ticket
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
        {$ticket->CustomerName},
        {$ticket->CustomerEmail},
        {$ticket->DateCreate},
        {$ticket->DateUpdate},
        {$ticket->Complaint});");
        
        if ($res){
            echo "Registro gravado com sucesso";
        }
    }

}

$dataBase = new TicketDAO(  );

$dataBase->insertTicket("teste");