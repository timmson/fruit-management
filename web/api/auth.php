<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(array("error" => "User is unauthorized"));
    session_unset();
    exit();
}

echo json_encode($_SESSION["user"]);
