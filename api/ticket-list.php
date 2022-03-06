<?php
$_POST = json_decode(file_get_contents('php://input'), TRUE);
require_once '../connection.php';
$db = new DB();
$where = '';
$result = [];
if(isset($_GET))
{
    if(!empty($_GET['category']))
    {
        $where .= " AND T.category IN (".$_GET['category'].")";
    }
    if(!empty($_GET['status']))
    {
        if($_GET['status'] == "Open")
        {
            $where .= " AND T.status IN ('In Progress','On Hold')";
        }
        elseif($_GET['status'] == "Closed")
        {
            $where .= " AND T.status IN ('Closed')";
        }
    }
}
$data = $db->query("SELECT T.*,C.`category`,C.`color`,C.`id` as category_id,COUNT(R.id) as replay FROM `ticket` as T INNER JOIN `category` as C ON T.category = C.id AND C.is_deleted = 0 LEFT JOIN `conversion` AS R ON R.`ticket_id` = T.`id`  WHERE 1 ".$where." AND T.is_deleted = 0 GROUP BY T.id ORDER BY T.datetime DESC");
if($data->num_rows>0)
{  
    while($row = $data->fetch_object())
    {
        $result[]=[
            'id' => $row->id,
            'name' => $row->name,
            'subject' => $row->subject,
            'email' => $row->email,
            'category' => ['id'=>$row->category_id,'title'=>$row->category,'color'=>$row->color],
            'status' => ['title'=>$row->status,'color'=>$asset['status'][$row->status]],
            'datetime' => ['formated'=>$db->time_elapsed_string($row->datetime),'unformated'=>$row->datetime],
            'replay' => $row->replay
        ];
    }
}
echo json_encode(["is_success"=>true,"data"=>$result]);
die;
?>