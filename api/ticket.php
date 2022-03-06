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
    $result['is_success'] = true;
    $ticket = $data->fetch_object();
    $arrConversion = [];
    $replay = $db->select('conversion',['ticket_id'=>$id]);
    if($replay['total_record']>0)
    {  
        while($row = $replay['rs']->fetch_object())
        {
            $attachments = [];
            if(!empty($row->attachments))
            {
                $attachments = explode('|',$row->attachments);
            }
            $arrConversion[] = [
                'sender'=>$row->sender,
                'name'=>($row->sender=='admin')? $db->config['admin_name'] : $ticket->name,
                'datetime' => ['formated'=>$db->time_elapsed_string($row->datetime),'unformated'=>$row->datetime],
                'description' => $row->description,
                'attachments' => $attachments,
            ];
        }
    }

    $attachments = [];
    if(!empty($ticket->attachments))
    {
        $attachments = explode('|',$ticket->attachments);
    }
    
    $result['ticket']=[
        'id' => $ticket->id,
        'name' => $ticket->name,
        'subject' => $ticket->subject,
        'email' => $ticket->email,
        'category' => ['id'=>$ticket->category_id,'title'=>$ticket->category,'color'=>$ticket->color],
        'status' => ['title'=>$ticket->status,'color'=>$asset['status'][$ticket->status]],
        'datetime' => ['formated'=>$db->time_elapsed_string($ticket->datetime),'unformated'=>$ticket->datetime],
        'description' => $ticket->description,
        'attachments' => $attachments,
        'conversion' => $arrConversion
    ];
}
else
{
    $result['is_success'] = false;
    $result['message'] = "İd hata";
}
echo json_encode($result);
die;
?>