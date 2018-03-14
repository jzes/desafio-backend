<?php 
namespace App\Controllers;

use App\Dao\TicketDAO;
use Google\Cloud\Language\LanguageClient;

class TicketController{
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
            $ticket->Complaint = false;
           
            $dataBase->insertTicket($ticket);
            $scores = [];
            foreach ($ticket->Interactions as &$interaction){
                if ($interaction->Sender == "Customer"){
                    $sentiment = $this->getSentiment($interaction->Message);
                    $scores[] = $sentiment["score"];
                    $interaction->Sentiment = strval($sentiment["score"]);
                    $ticket->Complaint = $this->checkComplaint($interaction->Message);
                } else {
                    $interaction->Sentiment = "0";
                }
                $dataBase->insertInteraction($interaction, $ticket->TicketID);
                //var_dump($interaction);
            }
            $ticket->SentimentAverage = array_sum($scores)/count($scores);
            $ticket->SLATimeHours = $this->getSLA($ticket->DateCreate, $ticket->DateUpdate);
            $ticket->Priority = $this->getPriority($ticket->SLATimeHours, $ticket->Complaint, $ticket->SentimentAverage);
            
            $dataBase->updateTicket($ticket);
            
        }
    }

    function getPriority($SLA, $complaint, $sentimentAverage){
        if (($SLA > 894) or $complaint or ($sentimentAverage < 0)){
            return "Alta";
        }
        return "Normal";
    }

    function getSLA($dateOpen, $dateLastUpdate){
        $dateOpen = StrToTime($dateOpen);
        $dateLastUpdate = StrToTime($dateLastUpdate);
        $dateDiff = $dateLastUpdate - $dateOpen;
        $dateDiffHours = round($dateDiff/(60*60));
        return $dateDiffHours;
    }

    function checkComplaint($message){
        $complaintWords = ["Procon", "ReclameAqui"];
        foreach ($complaintWords as &$complaintWord){
            if (strpos($message, $complaintWord)){
                return true;
            }
        }
        return false;
    }

    function getSentiment($interactionMessage){
        $language = new LanguageClient([
            'projectId' => 'drivemanager-174718'
        ]);
        $annotation = $language->analyzeSentiment($interactionMessage);
        
        $sentiment = $annotation->sentiment();
        return $sentiment;
    }

}


