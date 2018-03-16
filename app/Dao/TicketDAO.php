<?php

namespace App\Dao;

class TicketDAO {
    public $connection;
    public $dataBase;
    public $server;
    public $user;
    public $password;

    function __construct(){
        $this->dataBase = "desafio";
        $this->server = "localhost";
        $this->user = "application";
        $this->password = "123@app";
        $this->connection = mysqli_connect($this->server, $this->user, $this->password);
    }

    function getTicketByPriority($value){
        $sqlQuery = "SELECT ticket.TicketID,
        ticket.CategoryID,
        ticket.CustomerID,
        ticket.CustomerName,
        ticket.CustomerEmail,
        ticket.DateCreate,
        ticket.DateUpdate,
        ticket.Complaint,
        ticket.SentimentAverage,
        ticket.Priority,
        ticket.SLATimeHours
        FROM desafio.ticket 
        where Priority = '{$value}';";
        return $this->fetchAndBuildTicketArray(mysqli_query($this->connection, $sqlQuery));        
    }

    function fetchAndBuildTicketArray($result){
        $resultRows = [];                    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ticketInteractions = $this->getInteractionsByTicketID($row["TicketID"]);
                $row["Interactions"] = $ticketInteractions;
                $resultRows[] = $row;
            }
            return $resultRows;
        }
        return;
    }

    function getTicketsBetweenDateCreate($dateCreateStart, $dateCreateEnd){
        $sqlQuery = "SELECT ticket.TicketID,
        ticket.CategoryID,
        ticket.CustomerID,
        ticket.CustomerName,
        ticket.CustomerEmail,
        ticket.DateCreate,
        ticket.DateUpdate,
        ticket.Complaint,
        ticket.SentimentAverage,
        ticket.Priority,
        ticket.SLATimeHours
        FROM desafio.ticket 
        where DateCreate between '{$dateCreateStart}' and '{$dateCreateEnd}';";
        return $this->fetchAndBuildTicketArray(mysqli_query($this->connection, $sqlQuery));
    }

    function getInteractionsByTicketID($ticketID){
        $sqlQuery = "SELECT interaction.IdInteraction,
                interaction.TicketID,
                interaction.Subject,
                interaction.Message,
                interaction.DateCreate,
                interaction.Sender,
                interaction.Sentiment,
                interaction.Magnitude
            FROM desafio.interaction
            WHERE interaction.TicketID = {$ticketID};";

        $result = mysqli_query($this->connection, $sqlQuery);
        $resultRows = [];                    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultRows[] = $row;
            }
            return $resultRows;
        }
        echo "\nErro\n";
        var_dump($sqlQuery);
    }

    function getTicketsWithOrder($orderField){
        $sqlQuery = "SELECT ticket.TicketID,
            ticket.CategoryID,
            ticket.CustomerID,
            ticket.CustomerName,
            ticket.CustomerEmail,
            ticket.DateCreate,
            ticket.DateUpdate,
            ticket.Complaint,
            ticket.SentimentAverage,
            ticket.Priority,
            ticket.SLATimeHours
        FROM desafio.ticket
        ORDER BY ticket.{$orderField};";

        return $this->fetchAndBuildTicketArray(mysqli_query($this->connection, $sqlQuery));
    }

    function insertInteraction($interaction, $ticketID){
        $sqlQuery = "INSERT INTO desafio.interaction
        (TicketID,
        Subject,
        Message,
        DateCreate,
        Sender,
        Sentiment, 
        Magnitude)
        VALUES
        ({$ticketID},
        '{$interaction->Subject}',
        '{$interaction->Message}',
        '{$interaction->DateCreate}',
        '{$interaction->Sender}',
        {$interaction->Sentiment},
        {$interaction->Magnitude});";
        
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
