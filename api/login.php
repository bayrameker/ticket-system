<?php
$_POST = json_decode(file_get_contents('php://input'), TRUE);
require_once '../connection.php';
$db = new DB();

$login['username'] = $_POST['username'];
$login['password'] = $_POST['password'];	
$loginData = $db->select('admin',$login);
if($loginData['total_record']==1)
{
    $result['is_success']=true;
    $result['admin_name']=$db->config['admin_name'];
    $result['message']="Giriş Başarılı";
    $result['total_close']=intval($db->count('ticket'," status = 'Closed' AND is_deleted = 0"));
    $result['total_open']=intval($db->count('ticket'," status IN ('In Progress','On Hold')  AND is_deleted = 0"));
    $result['total']=intval($result['total_close']+$result['total_open']);
    $result['total_category']=intval($db->count('category'," is_deleted = '0'"));

//    $result['meta'] = [];
//    $arrStatus = [];
//    foreach($asset['status'] as $status => $color)
//    {
//        $arrStatus[] = ['title'=>$status,'color'=>$color];
//    }
//    $result['meta']['status'] = $arrStatus;
//    
//    $data = $db->select('category',['is_deleted'=>'0']);
//    $arrCategory = [];
//    if($data['total_record']>0)
//    {  
//        while($row = $data['rs']->fetch_object())
//        {
//            $arrCategory[] = ['id'=>$row->id,'title'=>$row->category,'color'=>$row->color]; 
//        }
//    }
//    $result['meta']['category'] = $arrCategory;
}
else
{
    $result['is_success']=false;
    $result['message']="Doğrulama hata";
}
echo json_encode($result);
die;
?>