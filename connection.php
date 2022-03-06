<?php
// burada hata kontrol aktif ama kapatılabilir
error_reporting(1);

//kullanıcı oturum kontrolü ve admin işlemleri için session başlattık
session_start();

//Zaman dilimi seçimi
date_default_timezone_set("Europa/Istanbul");



$asset['status'] = ['Açık' => '#e4e7ea', 'Beklemede' => '#f96868', 'Kapalı' => '#15c377'];

if (file_exists(__DIR__ . "/config/database.php")) {
    require_once __DIR__ . "/config/database.php";
    require_once __DIR__ . "/libs/vendor/autoload.php";

    class DB {

        private $db;
        public $config;

        public function __construct() {
            $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($this->db->connect_error) {
                die("Bağlantı hatası: " . $conn->connect_error);
            }

            $rsConfig = $this->select('config');
            $config = [];
            while ($row = $rsConfig['rs']->fetch_object()) {
                $this->config[$row->config_name] = $row->config_value;
            }
        }

        public function insert($tbl, $data) {
            $sql = "INSERT INTO `$tbl`";
            $fields = array_keys($data);
            $values = array_values($data);
            $sql .= "(`" . implode("`,`", $fields) . "`)";
            $sql .= " VALUES('" . implode("','", $values) . "')";
            return $this->db->query($sql);
        }

        public function delete($tbl, $where) {
            $sql = "DELETE FROM `$tbl`";
            $arrWhere = [];
            foreach ($where as $field => $val) {
                $arrWhere[] = " `$field` = '" . mysqli_real_escape_string($this->db, $val) . "' ";
            }
            $sql .= "WHERE 1 AND" . implode(" AND ", $arrWhere);
            return $this->db->query($sql);
        }

        public function update($tbl, $data, $where) {
            $sql = "UPDATE `$tbl` SET ";

            $arrfield = [];
            foreach ($data as $field => $val) {
                $arrfield[] = " `$field` = '" . mysqli_real_escape_string($this->db, $val) . "' ";
            }
            $sql .= " " . implode(", ", $arrfield) . " ";
            $arrWhere = [];
            foreach ($where as $field => $val) {
                $arrWhere[] = " `$field` = '" . mysqli_real_escape_string($this->db, $val) . "' ";
            }
            $sql .= "WHERE 1 AND" . implode(" AND ", $arrWhere);

            return $this->db->query($sql);
        }

        public function select($tbl, $where = [], $field = "*") {
            $sql = "SELECT ";
            if (is_array($field)) {
                $sql .= "`" . explode("`,`", $field) . "`";
            } else {
                $sql .= " $field ";
            }
            $sql .= " FROM `$tbl` ";
            if (!empty($where)) {
                if (is_array($where)) {
                    $arrWhere = [];
                    foreach ($where as $field => $val) {
                        $arrWhere[] = " `$field` = '" . mysqli_real_escape_string($this->db, $val) . "' ";
                    }
                    $sql .= "WHERE 1 AND" . implode(" AND ", $arrWhere);
                } else {
                    $sql .= "WHERE 1 AND " . $where;
                }
            }
            $rs = $this->db->query($sql);

            $return = [];
            if ($rs->num_rows > 0) {
                $return['total_record'] = $rs->num_rows;
                $return['rs'] = $rs;
            } else {
                $return['total_record'] = 0;
            }
            return $return;
        }

        public function count($tbl, $where = []) {
            $sql = "SELECT count(*) as `count` FROM `$tbl` ";
            if (!empty($where)) {
                if (is_array($where)) {
                    $arrWhere = [];
                    foreach ($where as $field => $val) {
                        $arrWhere[] = " `$field` = '" . mysqli_real_escape_string($this->db, $val) . "' ";
                    }
                    $sql .= "WHERE 1 AND" . implode(" AND ", $arrWhere);
                } else {
                    $sql .= "WHERE 1 AND " . $where;
                }
            }
            $rs = $this->db->query($sql);
            $rs = $rs->fetch_object();
            return $rs->count;
        }

        public function query($sql) {
            return $this->db->query($sql);
        }

        public function uploadfiles($files, $path) {
            $arrFiles = [];
            if (!empty($files['name'][0])) {
                if (!is_dir($path)) {
                    mkdir($path);
                }
                foreach ($files['error'] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        $tmp_name = $files['tmp_name'][$key];
                        $name = $files['name'][$key];

                        if (file_exists($path . $name)) {
                            $name = microtime(true) . "_" . $name;
                        }
                        $uploadfile = $path . basename($name);
                        if (move_uploaded_file($tmp_name, $uploadfile)) {
                            $arrFiles[] = $uploadfile;
                        }
                    }
                }
            }
            if (empty($arrFiles)) {
                return '';
            } else {
                return implode('|', $arrFiles);
            }
        }

        public function time_elapsed_string($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'Yıl',
                'm' => 'Ay',
                'w' => 'Hafta',
                'd' => 'Gün',
                'h' => 'Saat',
                'i' => 'Dakika',
                's' => 'Saniye',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full)
                $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        }


        /* Smtp üzerinden Destekler ile ilgili mail gönderme kısmı şimdilik aktif değil ama sunucu üzerinde gerekli ayarlamalar yapılınca aktif olacaktır. */

    /*    function sendmail($email, $html, $subject) {
            $transport = (new Swift_SmtpTransport($this->config['smtp_host'], $this->config['smtp_port'], $this->config['smtp_secure']))
                    ->setUsername($this->config['smtp_email'])
                    ->setPassword($this->config['smtp_password']);
            
            $mailer = new Swift_Mailer($transport);
            
            $message = (new Swift_Message($subject))
                    ->setFrom([$this->config['smtp_email'] => $this->config['site_name'] ])
                    ->setTo([$email])
                    ->setBody($html,'text/html');
            $result = $mailer->send($message);
            
                $done = 2;
               
            echo $done;
        } */



    }

}
?>
