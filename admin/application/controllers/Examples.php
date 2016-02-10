<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		session_start();
		if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','mustafamnr@gmail.com')))
		{

		}else
		 header("Location: http://www.faizstudents.com/users/login.php");

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	function faiz()
{
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('thalilist');

    $output = $crud->render();
 
    $this->_example_output($output);
}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

		
	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}
			
}