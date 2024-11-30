<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Utils extends CI_Model
{

    var $client_service = "frontend-client";
    var $auth_key       = "simplerestapi";
    var $no_auth       = "NoAuth";

    public function check_no_auth()
    {
        $no_auth = $this->input->get_request_header('NoAuth', TRUE);
        if ($no_auth == $this->no_auth) {
            return true;
        } else {
            return $this->json_output(401, array('status' => 401, 'message' => 'no auth need.'));
        }
    }

    public function check_auth_client()
    {
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);
        if ($client_service == $this->client_service && $auth_key == $this->auth_key) {
            return true;
        } else {
            return $this->json_output(401, array('status' => 401, 'message' => 'Unauthorized.'));
        }
    }

    function json_output($statusHeader, $response)
    {
        $ci = &get_instance();
        $ci->output->set_content_type('application/json');
        $ci->output->set_status_header($statusHeader);
        $ci->output->set_output(json_encode($response));
    }

    public function auth()
    {
        $users_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $q  = $this->db->where('status', '1')->select('expired_at', 'status')->from('t_user_token')->where('user_id', $users_id)->where('token', $token)->get()->row();
        if ($q == "") {
            return $this->json_output(401, array('status' => 401, 'message' => 'Unauthorized.'));
        } else {
            if ($q->expired_at < date('Y-m-d H:i:s')) {
                return $this->json_output(401, array('status' => 401, 'message' => 'Your session has been expired.'));
            } else {
                $updated_at = date('Y-m-d H:i:s');
                $expired_at = date("Y-m-d H:i:s", strtotime('+1 week'));
                $this->db->where('user_id', $users_id)->where('token', $token)->update('t_user_token', array('expired_at' => $expired_at, 'modified_date' => $updated_at));
                return array('status' => 200, 'message' => 'Authorized.');
            }
        }
    }

    public function send_email($email_to, $subject, $message)
    {
        $from_email = "info@esatpam.id";
        //Load email library 
        $this->load->library('email');
        $config = array();
        $config['charset'] = 'utf-8';
        $config['useragent'] = 'Codeigniter';
        $config['protocol'] = "smtp";
        $config['mailtype'] = "html";
        $config['smtp_host'] = "ssl://esatpam.id"; //pengaturan smtp
        $config['smtp_port'] = "465";
        $config['smtp_timeout'] = "400";
        $config['smtp_user'] = "info@esatpam.id"; // isi dengan email kamu
        $config['smtp_pass'] = "info123654789"; // isi dengan password kamu
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);

        $this->email->from($config['smtp_user']);
        $this->email->to($email_to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            return array('status' => 200, 'message' => 'email sent.');
        } else {
            //show_error($this->email->print_debugger());
            return array('status' => 404, 'message' => 'error.');
        }
    }

    public function send_notif($title, $description, $user_id_target, $user_id_pengirim, $topic)
    {
        $firebaseToken = "";
        $where = '(id="' . $user_id_target . '")';
        $q  = $this->db->select('firebase_token')->from('t_user')->where($where)->get()->row();
        if ($q == "") {
            return array('status' => 404, 'message' => 'username atau password salah.');
        } else {
            $firebaseToken = $q->firebase_token;
        }
        $url = "https://fcm.googleapis.com/fcm/send";
        //$token = "dIk9W_8Up6c:APA91bGVboVLZdG91n8T8jbE84cDMAlQl7WKeygIZSbiMF_XN0qc2WnuzupJPVTFuyTBKmkivlFwYr5kafjb-rTpxIAoafdqD3Bk8lh0JO7cVgCZrplpaTmE_ngqXL3Ou50ap--jaZmO";
        $serverKey = '	AAAAsMqi2q8:APA91bHQRjPxK3ai9LrE4eV-5ILsMsQMD49HgtEGLBCK3EaioVybr6IGY3MIly9LIL-B84oiVB-6OujAMGhVxfYlSnqERJQtlaHjqEkBU8htafbSn5e2t3HSZ-Z7N--J0aZAmy8h4lEy';
        $notification = array('title' => $title, 'body' => $description, 'sound' => 'default', 'badge' => '1');
        $arrayToSend = array('to' => $firebaseToken, 'notification' => $notification, 'priority' => 'high');
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Send the request
        $response = curl_exec($ch);
        //Close request
        if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);

        $created_date = date("Y-m-d H:i:s");
        $sql = 'insert into t_notification (title, description, sender_id, destination_id, created_date) values ("' . $title . '", "' . $description . '", "' . $user_id_pengirim . '", "' . $user_id_target . '", "' . $created_date . '")';
        $query = $this->db->query($sql);
    }

    public function sendToSingle($to, $message)
    {
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // Sending message to a topic by topic name
    public function sendToTopic($to, $message)
    {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // sending push message to multiple users by firebase registration ids
    public function sendMultiple($registration_ids, $message)
    {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    // function makes curl request to firebase servers
    public function sendPushNotification($fields)
    {

        require_once __DIR__ . '/config.php';
        $serverKey = '	AAAAsMqi2q8:APA91bHQRjPxK3ai9LrE4eV-5ILsMsQMD49HgtEGLBCK3EaioVybr6IGY3MIly9LIL-B84oiVB-6OujAMGhVxfYlSnqERJQtlaHjqEkBU8htafbSn5e2t3HSZ-Z7N--J0aZAmy8h4lEy';
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return $result;
    }

    // function makes curl request to firebase servers
    private function sendFCM($fields)
    {

        $serverKey = 'AAAA6oNf4ho:APA91bFth5z9_ZFxuVLbrw_k7-aMiOMoYe8nj17eWc5exCFYySYSJc2rt9NPA8m1L9UGV-tu4FsPRX5lUuXYoE2ZYYUj5NjsjZHXPxSHWJ-4QVl3tiXVb3e4izQT84afMJzUeSRVwZyl';

        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return $result;
    }

    public function update_notif($notif_id)
    {

        $created_date = date("Y-m-d H:i:s");
        $modified_date = date("Y-m-d H:i:s");

        $sql = 'update t_notif set status=2, modified_date="' . $modified_date . '" where notif_id=' . $notif_id . '';
        $query = $this->db->query($sql);
        return array('status' => 200, 'message' => 'notif updated');
    }

    public function delete_notif($notif_id)
    {

        $created_date = date("Y-m-d H:i:s");
        $modified_date = date("Y-m-d H:i:s");

        $sql = 'update t_notif set status=3, modified_date="' . $modified_date . '" where notif_id=' . $notif_id . '';
        $query = $this->db->query($sql);
        return array('status' => 200, 'message' => 'notif deleted');
    }

    public function get_notif($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/job/';
        $sql = 'select * from t_notif where user_id=' . $id . ' or user_id=0 and status!=3 order by notif_id DESC';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Berhasil",
                'data' => $result
            );
        } else {
            return array(
                'status' => 204,
                'message' => "Data Kosong",
                'data' => $result
            );
        }
    }
}
