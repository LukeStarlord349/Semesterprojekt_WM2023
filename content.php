<?php
$page;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'home';
}
switch ($page) {
    case 'help':
        include "help/help_site.php";
        break;
    case 'impressum':
        include "impressum/impressum.php";
        break;
    case 'booking' :
        include "booking/booking.php";
        break;
    case 'login' :
        include "login/login.php";
        break;
    case 'register' :
        include "register/create_account.php";
        break;
    case 'news' :
        include "news/news.php";
        break;
    case 'account' :
        include "account/account.php";
        break;
    case 'rooms' :
        include "rooms/rooms.php";
        break;
    default :
        include "home/home.php";
        break;
}
?>