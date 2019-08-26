<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 12/30/2018
 * Time: 2:25 PM
 */

class Signup extends CI_Controller
{
    public function index()
    {
        if (userLoggedIn()) {
            redirect('user');
        }
        else{
            $this->load->view('header/header');
            $this->load->view('header/css');
            $this->load->view('header/navbar');
            $this->load->view('home/signup');
            $this->load->view('header/footer');
            $this->load->view('header/htmlclose');
        }
    }

    public function newUser()
    {
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $data['first_name'] = $this->input->post('fname', true);
            $data['last_name'] = $this->input->post('lname', true);
            $data['email'] = $this->input->post('email', true);
            $data['password'] = $this->input->post('password', true);
            $data['date'] = date('Y-m-d H:i:s');
            $data['link'] = random_string('alnum', 20);
            $data['password'] = hash('md5', $data['password']);

            $myUser = $this->modUser->checkUser($data);
            if (count($myUser) == 1) {
                setFlashData('alert-danger','user already exist.','signup');
            } else {
                $userAdd = $this->modUser->addUser($data);
                if ($userAdd) {
                   // echo 'we have added';
                    $this->senbdEamilUser($data);
                } else {
                    setFlashData('alert-danger','we can\'t add the user right now please try again.','signup');

                }
            }

        }
        //var_dump($data);
    }

    public function activateAccount($link)
    {
        if (!empty($link) && isset($link)) {
            $user = $this->modUser->checkLink($link);
            if (count($user) == 1) {
                $userData['link'] = $user[0]['link'].'ok';
                $userData['status'] = 1;
                $updateUser = $this->modUser->activateUser($user[0]['uId'],$userData);
                if ($updateUser) {
                    echo 'You have successfully activated the account.';
                }
                else{
                    echo 'You can\'t activate your account right now plese try again.';
                }

            }
            else{
                echo 'not available the link or expire';
            }
        }
        else{
            echo 'Check your email address and try again';
        }
    }
    private function senbdEamilUser($data){
        $userLink = site_url('signup/activateAccount/'.$data['link']);
        $myData ='<p>'.$data['first_name'].', please click on the link to activate your <a href="'.$userLink.'">account</a> </p>';
        $config = array(
            'useragent' => 'CodeIgniter',
            'protocol' => 'mail',
            'mailpath' => '/usr/sbin/sendmail',
            'smtp_host' => 'localhost',
            'smtp_user' => 'info@shakzee.com',
            'smtp_pass' => 'xyzhere',
            'smtp_port' => 25,
            'smtp_timeout' => 55,
            'wordwrap' => TRUE,
            'wrapchars' => 76,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'validate' => FALSE,
            'priority' => 3,
            'crlf' => "\r\n",
            'newline' => "\r\n",
            'bcc_batch_mode' => FALSE,
            'bcc_batch_size' => 200,
        );
        $this->email->from('info@shakzee.com');
        $this->email->to($data['email']);
        $this->email->subject('Account Activation');
        $this->email->message($myData);
        $this->email->set_mailtype('html');
        if ($this->email->send()) {
            return true;
        }
        else{
            return false;
        }

     }



}//controller