<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 12/30/2018
 * Time: 4:20 PM
 */

class Login extends CI_Controller
{
    public function index()
    {
        $this->load->view('header/header');
        $this->load->view('header/css');
        $this->load->view('header/navbar');
        $this->load->view('home/login');
        $this->load->view('header/footer');
        $this->load->view('header/htmlclose');
    }

    public function checkUser()
    {
        $this->form_validation->set_rules('email','Email','required');
        $this->form_validation->set_rules('password','Email','required');
        if ($this->form_validation->run() == false) {
          $this->index();
        }else{
            $data['email'] = $this->input->post('email', true);
            $data['password'] = $this->input->post('password', true);
            $data['password'] = hash('md5',$data['password']);
            $user = $this->modUser->checkUser($data);
            if (count($user) == 1) {
                switch ($user[0]['status']) {
                    case 0:
                        //echo '';
                        setFlashData('alert-danger','Please activate your account before login','login');
                        break;
                    case 1:
                        if ($user[0]['password'] == $data['password']) {
                            //session here
                           $myActualUser =  array(
                                'uId'=>$user[0]['uId'],
                                'first_name'=>$user[0]['first_name'],
                                'last_name'=>$user[0]['last_name'],
                                'email'=>$user[0]['email'],
                                'date'=>$user[0]['date']
                            );
                           $this->session->set_userdata($myActualUser);
                            if ($this->session->userdata('uId')) {
                                redirect('user');
                            }else{
                                setFlashData('alert-danger','session is not created','login');

                            }
                        }
                        else{
                            setFlashData('alert-danger','Your password is invalid','login');

                        }

                        break;
                    case 2:
                        setFlashData('alert-danger','the admin blocked you.','login');

                        break;
                }

            }else{
                echo 'The email is not exist.';
            }
        }
    }
}