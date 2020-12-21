<?php

class Emailsender_model extends MY_Model
{
    function __construct()
    {
    }
    
    public function sendMail($to, $subject, $message)
    {
  
        $this->load->library('email');    
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset']  = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from('neclife2020@gmail.com', 'Nectar lifescience ltd.');
        $this->email->to($to);
    
        $this->email->subject($subject);
        $this->email->message($message);
        
        if ($this->email->send()) {
           
            return true;
        } else {
            
            return false;
        }
        
        
        
        /****************smtp mail *******************/
        
   /*     $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'neclife2020@gmail.com', // change it to yours
            'smtp_pass' => 'kaeyzdxyaqkysedw', // change it to yours
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from('neclife2020@gmail.com'); // change it to yours
        $this->email->to($to);// change it to yours
        $this->email->subject($subject);
        $this->email->message($message);
        if($this->email->send())
        {
        echo 'Email sent.';
        }
        else
        {
        show_error($this->email->print_debugger());
        }*/
    }
    
}
?>