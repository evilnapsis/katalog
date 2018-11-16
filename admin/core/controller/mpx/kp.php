<?php

require_once "mercadopago.php";

$mp = new MP("434686056244118", "mDJBTvYVOksoCY6O4FyNHauihYLWbnou");

if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
    http_response_code(400);
    return;
}

$topic = $_GET["topic"];
$merchant_order_info = null;

switch ($topic) {
    case 'payment':
        $payment_info = $mp->get("/collections/notifications/".$_GET["id"]);
        $merchant_order_info = $mp->get("/merchant_orders/".$payment_info["response"]["collection"]["merchant_order_id"]);
        break;
    case 'merchant_order':
        $merchant_order_info = $mp->get("/merchant_orders/".$_GET["id"]);
        break;
    default:
        $merchant_order_info = null;
}

if($merchant_order_info == null) {
    echo "Error obtaining the merchant_order";
    die();
}

if ($merchant_order_info["status"] == 200) {
    print_r($merchant_order_info["response"]["payments"]);
    print_r($merchant_order_info["response"]["shipments"]);
}

?>