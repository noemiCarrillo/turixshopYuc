<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct() {        
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->helper('form', 'url');
		$this->load->library('session');  
	}

	public function index()
	{
		$this->load->library('form_validation');
		$this->load->view('login');
	}

	public function acceso()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user', 'user', 'required');
		$this->form_validation->set_rules('pwd', 'pwd', 'required');
		
		if($this->form_validation->run() === FALSE){
			$data['msj'] = 'Datos incompletos';
			$this->load->view('login',$data);
		}else{
			$usuario = $this->input->post('user');
			$pwd = $this->input->post('pwd');
			$user_id = $this->Login_model->valida_acceso($usuario,$pwd);
			echo $user_id; die;
			if($user_id)
			{
				//Crear session
				$user_data = array(
					'user_id' => $user_id->idUsuario,
					'user_name' => $usuario
				);
				$this->session->set_userdata($user_data);

				// Message
				$this->session->set_flashdata('user_loggedin','Acceso cón exito');
				$this->load->view('dashboard');
			}
			else{
				$this->session->set_flashdata('login_failed','Acceso incorrecto');
				//redirect('login');
				$this->load->view('login');
				//redirect(base_url().'login','refresh');
			}
		}
	}

	// cerrar session
	public function logout(){
		// eliminar datos de usuario
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_name');

		//Mensaje	
		$this->session->set_flashdata('user_loggedout','Session finalizada');
		redirect(base_url());
	}
		
}
