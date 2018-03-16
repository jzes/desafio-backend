<?php
namespace App\Controllers;

use App\Dao\TicketDAO;

class OrderBy {

    public $ticketDAO;

    function __construct(){
        $this->ticketDAO = new TicketDAO();
    }

    function orderPage($field, $pageSize, $pageNumber){
        $tickets = $this->order($field);
        $pageTickets = array_splice($tickets, $pageNumber*$pageSize , $pageSize);
        return $pageTickets;
    }

    function order($field){
        return $this->ticketDAO->getTicketsWithOrder($field);
    }
}