<?php 
namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Mailer{

    const HOST_NAME = "smtp.gmail.com";
    const HOST_EMAIL = "maensadeq1999mh@gmail.com";
    const HOST_PASS = "maen1199$";

    private $mailer;

    public function __construct(){
        try {
            $this->mailer = new PHPMailer(true);
            //Server settings
            $this->mailer->isSMTP();                                           
            $this->mailer->Host       = Mailer::HOST_NAME;                    
            $this->mailer->SMTPAuth   = true;                                   
            $this->mailer->Username   = Mailer::HOST_EMAIL;                     
            $this->mailer->Password   = Mailer::HOST_PASS;                               
            $this->mailer->SMTPSecure = "ssl";         
            $this->mailer->Port       = 465;
            $this->mailer->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );
        }catch(\Exception $e){
            throw new \Exception($e->getMessage(),"500");
        }
    }

    public function send($from, $to, $subject , $body, $imgs = null, $withReply = false){
        try{
            $this->mailer->setFrom($from, $from);
            $this->mailer->addAddress($to);
            if($withReply != false){
                $this->mailer->addReplyTo($from, 'Reply');
            }
            if(!empty($imgs)){
                foreach($imgs as $imgname => $url){
                    $this->mailer->AddEmbeddedImage($url, $imgname);
                }
            }
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = "UTF-8";                             
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
            $this->mailer->send();
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}

?>