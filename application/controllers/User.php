<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 12/30/2018
 * Time: 4:38 PM
 */

class User extends CI_Controller
{
    public function index()
    {
        if (userLoggedIn()) {
            echo 'Welcome ' .$this->session->userdata('first_name');
        }else{
            setFlashData('alert-danger','please login now.','signup');
        }
    }


    public function logOut()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}