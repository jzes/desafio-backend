<?php
namespace App\Controllers;

use App\Dao\TicketDAO;

class FilterBy{
    public $ticketDAO;

    function __construct(){
        $this->ticketDAO = new TicketDAO();
    }

    function filterBetweenDates($dateStart, $dateEnd){
        return $this->ticketDAO->getTicketsBetweenDateCreate($dateStart, $dateEnd);
    }

    function filterBetweenDatesPage($dateStart, $dateEnd, $pageSize, $pageNumber){
        $tickets = $this->filterBetweenDates($dateStart, $dateEnd);
        $pageTickets = array_splice($tickets, $pageNumber*$pageSize , $pageSize);
        return $pageTickets;
    }

    function filterByPriority($value){
        return $this->ticketDAO->getTicketByPriority($value);
    }

    function filterByPriorityPage($value, $pageSize, $pageNumber){
        $tickets = $this->filterByPriority($value);
        $pageTickets = array_splice($tickets, $pageNumber*$pageSize , $pageSize);
        return $pageTickets;
    }
}
