<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 1/26/2018
 * Time: 7:31 PM
 */

class Home extends  CI_Controller
{

	public function index()
	{
		$this->load->view('header/header');
		$this->load->view('header/css');
		$this->load->view('header/navbar');
		$this->load->view('home/mainHome');
		$this->load->view('header/footer');
		$this->load->view('header/htmlclose');

	}
	public function aboutus()
	{
		$this->load->view('header/header');
		$this->load->view('css/extracss');
		$this->load->view('header/css');
		$this->load->view('header/navbar');
		$this->load->view('about/mainHome');
		$this->load->view('header/footer');
		$this->load->view('js/extrajs');
		$this->load->view('header/htmlclose');

	}

	public function login()
	{
		$this->load->view('header/header');
		$this->load->view('header/css');
		$this->load->view('header/navbar');
		$this->load->view('login/index');
		$this->load->view('header/footer');
		$this->load->view('header/htmlclose');

	}
}//class ends here
