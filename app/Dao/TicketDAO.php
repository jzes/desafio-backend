<?php

namespace App\Dao;

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
        Sentiment)
        VALUES
        ({$ticketID},
        '{$interaction->Subject}',
        '{$interaction->Message}',
        '{$interaction->DateCreate}',
        '{$interaction->Sender}',
        {$interaction->Sentiment});";
        
        $res = mysqli_query($this->connection, $sqlQuery);
        
        if ($res){
            echo "\nInteraction gravado com sucesso\n";
            return;
        }
        
        echo "\nErro\n";
        var_dump($sqlQuery);
    }

    function updateTicket($ticket){
        $ticket->Complaint = var_export($ticket->Complaint, true);
        $sqlQuery = "UPDATE desafio.ticket SET
        Complaint = {$ticket->Complaint},
        SentimentAverage = {$ticket->SentimentAverage},
        Priority = '{$ticket->Priority}',
        SLATimeHours = {$ticket->SLATimeHours} 
        WHERE TicketID = {$ticket->TicketID};";
        
        $res = mysqli_query($this->connection, $sqlQuery);
        
        if ($res){
            echo "\nTicket Atualizado com sucesso\n";
            return;
        }
        echo "\nERRO\n";
        var_dump($sqlQuery);
    }

    function insertTicket($ticket){
        echo "++++++++++++++++++++++++++\n";
        
        $ticket->Complaint = var_export($ticket->Complaint, true);
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
            echo "\nTicket gravado com sucesso\n";
            return;
        }
        echo "\nERRO\n";
        var_dump($sqlQuery);
    }
}
