<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: access');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow_credentails: true');
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../objects/tree.php';

    $database = new Database();
    $db = $database->getConnection();

    $person = new Tree($db);

    $person->id = isset($_GET['id']) ? $_GET['id'] : die();

    $person->getPerson();

    if($person != null){
        $person_arr = array(
            'son' => $person->son,
            'father' => $person->father,
            'grandFather' => $person->grandFather
        );

        http_response_code(200);
        echo json_encode($person_arr);
    }
    else{
        http_response_code(404);
        echo json_encode(array('message' => 'Person does not exist'));
    }
?>