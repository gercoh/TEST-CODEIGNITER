<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 15.09.2018
 * Time: 22:15
 */
//defined('BASEPATH') OR exit('No direct script access allowed');

class History extends  CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        return $this->load->view("history");
    }
}