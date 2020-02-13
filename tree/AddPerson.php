<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../objects/tree.php';

    $database = new Database();
    $db = $database->getConnection();

    $tree = new Tree($db);

    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data->name) && !empty($data->birth_date && !empty($data->parent_id && !empty($data->type)))){
        $tree->name = $data->name;
        $tree->birth_date = $data->birth_date;
        $tree->parent_id = $data->parent_id;
        $tree->type = $data->type;

        if($tree->create()){
            http_response_code(201);
            echo json_encode(array('message' => 'Person was created successfuly'));
        }
        else{
            http_response_code(503);
            echo json_encode(array('message' => 'Unable to create person'));
        }
    }
    else{
        http_response_code(400);
        echo json_encode(array('message' => 'Unable to create person. Data is incomplete'));
    }
?>