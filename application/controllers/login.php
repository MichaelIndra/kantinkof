<?php
    class login extends CI_Controller{
        

        function index(){
		$this->load->view('v_login');
	}
 
	function aksi_login(){
		$this->load->model('model_login');
                $username = $this->input->post('username');
		$password = $this->input->post('password');
                
		$where = array(
			'nama' => $username,
			'password' => md5($password)
			);
		$cek = $this->model_login->cek_login("user",$where)->num_rows();
                $data = $this->model_login->cek_login("user",$where);
                if($cek > 0){
                    foreach ($data->result_array() as $r)
                    {
                        $komsel = $r['komsel'];
                    }
                    
			$data_session = array(
				'nama' => $username,
				'status' => "login",
                                'komsel' => $komsel
				);
 
			$this->session->set_userdata($data_session);
 
			redirect("welcome");
 
		}else{
			echo "Username dan password salah !";
		}
	}
 
	function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}
    }

