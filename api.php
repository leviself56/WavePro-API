<?php
require_once("class.wavepro.php");
header("Content-Type: application/json");

$_POST = json_decode(file_get_contents("php://input"), true);
if (!isset($_POST)) {
    $error  =   json_encode(array(
        "error"         =>  array(
            "status"        =>  404,
            "message"       =>  "WavePro REST API requires POST"
    )), JSON_PRETTY_PRINT);
    http_response_code(404);
    print $error;
    die();
}

if (!isset($_POST['ip'])) {
    $error  =   json_encode(array(
        "error"         =>  array(
            "status"        =>  404,
            "message"       =>  "ip field required"
    )), JSON_PRETTY_PRINT);
    http_response_code(404);
    print $error;
    die();
}

if (!isset($_POST['username'])) {
    $error  =   json_encode(array(
        "error"         =>  array(
            "status"        =>  404,
            "message"       =>  "username field required"
    )), JSON_PRETTY_PRINT);
    http_response_code(404);
    print $error;
    die();
}

if (!isset($_POST['password'])) {
    $error  =   json_encode(array(
        "error"         =>  array(
            "status"        =>  404,
            "message"       =>  "password field required"
    )), JSON_PRETTY_PRINT);
    http_response_code(404);
    print $error;
    die();
}

$WavePro = new WavePro($_POST['ip'], $_POST['username'], $_POST['password']);

if (!isset($_POST['function'])) {
    $error  =   json_encode(array(
        "error"         =>  array(
            "status"        =>  404,
            "message"       =>  "function field required"
    )), JSON_PRETTY_PRINT);
    http_response_code(404);
    print $error;
    die();
}


switch ($_POST['function']) {
    case "get.interfaces":
        print json_encode($WavePro->GetInterfaces(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        break;

    case "get.device":
        print json_encode($WavePro->GetDevice(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        break;

    case "get.statistics":
        print json_encode($WavePro->GetStatistics(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        break;

    case "get.wireless.statistics":
        print json_encode($WavePro->GetWirelessStatistics(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        break;

    case "get.neighbors":
        print json_encode($WavePro->GetNeighbors(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        break;
    
    default:
        $error = json_encode(array(
            "error"     =>  array(
                "status"    =>  404,
                "message"   =>  "Function not found!"
            )
        ), JSON_PRETTY_PRINT);
        print $error;
        http_response_code(404);
        die();
}
?>