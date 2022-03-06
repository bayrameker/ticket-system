<?php
$_POST = json_decode(file_get_contents('php://input'), TRUE);
require_once '../connection.php';
$db = new DB();
$where = '';
$result = [];
$id = $_POST['ticket_id'];
$data = $db->query("SELECT T.*,C.`category`,C.`color`,C.`id` as category_id FROM `ticket` as T INNER JOIN `category` as C ON T.category = C.id AND C.is_deleted = 0 WHERE 1 AND T.is_deleted = 0 AND T.id = '$id'");

if($data->num_rows>0)
{
    $arrUpdate = [];
    if(!empty($_POST['category']))
    {
        $arrUpdate['category'] = $_POST['category'];
    }
    if(!empty($_POST['status']))
    {
        $arrUpdate['status'] = $_POST['status'];
    }
    if(!empty($arrUpdate))
    {
        if($db->update('ticket',$arrUpdate,['id'=>$id]))
        {
            $result['is_success'] = true;
            $result['message'] = "Güncellendi.";
        }
        else
        {
            $result['is_success'] = false;
            $result['message'] = "Hata";
        }    
    }
    else
    {
        $result['is_success'] = false;
        $result['message'] = "Kayıp";
    }
    
}
else
{
    $result['is_success'] = false;
    $result['message'] = "İd bulunamadı";
}
echo json_encode($result);
die;
?>