<?php

    header('Access-Control-Allow-Oigin: *');
    header('Access-Control-Allow-Headers: access');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow_credentails: true');
    header('Content-Type: application/json; charset=UTF-8');

    include_once '../config/database.php';
    include_once '../objects/tree.php';

    $database = new Database();
    $db = $database->getConnection();

    $person = new Tree($db);

    $date1 = isset($_GET['date1']) ? $_GET['date1'] : die();
    $date2 = isset($_GET['date2']) ? $_GET['date2'] : die();

    $stmt = $person->GetpersonsBetweenDates($date1, $date2);
    $num = $stmt->rowCount();

    if($num > 0){
        $persons = array();
        $persons['records'] = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $item = array(
                'id' => $id,
                'name' => $name,
                'birth_date' => $birth_date,
                'parent_id' => $parent_id,
                'type' => $type,
            );

            array_push($persons["records"], $item);
        }

        http_response_code(200);
        echo json_encode($persons);
    }
    else{
        http_response_code(404);
        echo json_encode(array("message" => "No persons found."));
    }

    // if($person != null){
    //     $person_arr = array(
    //         'id' => $person->id,
    //         'birth_date' => $person->birth_date,
    //         'parent_id' => $person->parent_id,
    //         'type' => $person->type,
    //     );

    //     http_response_code(200);
    //     echo json_encode($person_arr);
    // }
    // else{
    //     http_response_code(404);
    //     echo json_encode(array('message' => 'Person does not exist'));
    // }

?>