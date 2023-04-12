<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: incalake
 * Date: 24/06/2017
 * Time: 09:20 AM
 */
class Errors extends CI_Controller
{
    public function page404()
    {
        $this->load->view('errors/404');
    }
}