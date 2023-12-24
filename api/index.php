<?php 
    $data = [];

    if (isset($_GET['option'])) {
        
        switch ($_GET['option']) {
            case 'status':
                $data['status'] = 'SUCCESS';
                $data['data'] = 'API running!'; // Conteúdo da API
                break;
            
            default:
                $data['status'] = 'ERROR';
                break;
        }
    } else {
        $data['status'] = 'ERROR';
    }

    function response($data_response) {
        header("Content-Type:application/json");
        echo json_encode($data_response);
    }

    response($data);
?>