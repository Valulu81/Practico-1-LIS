<?php
session_start();
$_SESSION['cart']=[];
echo json_encode([
    "status" => "success",
    "cart" =>[]
]);