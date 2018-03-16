<?php
namespace App;

require_once __DIR__ . "/vendor/autoload.php";

use App\Resources\TicketDataBaseLoader;
use Silex\Application;
use App\Controllers\OrderBy;
use App\Controllers\FilterBy;


$ticketReader = new TicketDataBaseLoader();
$ticketReader->readTickets();
//$ticketReader->loadDataBase();

$app = new Application();
$app->get('/tickets/orderby/{field}', function($field) use($app) {
    $orderByController = new OrderBy();
    $tickets = $orderByController->order($field);
    return $app->json($tickets);
});

$app->get('/tickets/orderby/{field}/pageSize/{pageSize}/pageNumber/{pageNumber}', function($field, $pageSize, $pageNumber) use($app) {
    $orderByController = new OrderBy();
    $ticketsPage = $orderByController->orderPage($field, $pageSize, $pageNumber);
    return $app->json($ticketsPage);
});

$app->get('/tickets/filter/dateCreate/{dateCreateStart}/between/{dateCreateEnd}', function($dateCreateStart, $dateCreateEnd) use($app) {
    $filterByController = new FilterBy();
    $ticketsPage = $filterByController->filterBetweenDates($dateCreateStart, $dateCreateEnd);
    return $app->json($ticketsPage);
});


$app->get('/tickets/filter/dateCreate/{dateCreateStart}/between/{dateCreateEnd}/pageSize/{pageSize}/pageNumber/{pageNumber}', function($dateCreateStart, $dateCreateEnd, $pageSize, $pageNumber) use($app) {
    $filterByController = new FilterBy();
    $ticketsPage = $filterByController->filterBetweenDatesPage($dateCreateStart, $dateCreateEnd, $pageSize, $pageNumber);
    return $app->json($ticketsPage);
});

$app->get('/tickets/filter/priority/{priorityValue}', function($priorityValue) use($app) {
    $filterByController = new FilterBy();
    $ticketsPage = $filterByController->filterByPriority($priorityValue);
    return $app->json($ticketsPage);
});


$app->get('/tickets/filter/priority/{priority}/pageSize/{pageSize}/pageNumber/{pageNumber}', function($priority, $pageSize, $pageNumber) use($app) {
    $filterByController = new FilterBy();
    $ticketsPage = $filterByController->filterByPriorityPage($priority, $pageSize, $pageNumber);
    return $app->json($ticketsPage);
});


$app->get('/hello/{field}', function($field) use($app) {
    
    return $app->escape($field);
});


$app->run();


?>