<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 12/30/2018
 * Time: 2:47 PM
 */

class ModUser extends CI_Model
{
    public function checkUser($data)
    {
        return $this->db->get_where('users',array('email'=>$data['email']))->result_array();
    }

    public function addUser($data)
    {
        return $this->db->insert('users',$data);
    }

    public function checkLink($link)
    {
        return $this->db->get_where('users',array('link'=>$link))->result_array();
    }

    public function activateUser($uId,$data)
    {
        $this->db->where('uId',$uId);
        return $this->db->update('users',$data);
    }
}