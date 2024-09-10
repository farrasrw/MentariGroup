<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!isset($_SESSION)) 
	session_start(); 

class error404 extends CI_Controller {

	function __construct(){
		parent::__construct();
    }
    
    function index(){
		redirect(base_url());
    }
}