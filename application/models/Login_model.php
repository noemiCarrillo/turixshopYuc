<?php
	class Login_model extends CI_Model{
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }
        
        public function valida_acceso($user,$pwd){
            $this->db->where('usuario',$user);   
            $this->db->where('contraseña');    
            $result = $this->db->get('t_usuarios');
            if ($result->num_rows() == 1) {
                return $result->row(0);
            }
            else{
                return false;
            }
        }
	}
?>