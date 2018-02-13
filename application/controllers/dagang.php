<?php
    class dagang extends CI_Controller{
        function __construct(){
            parent::__construct();
	
            if($this->session->userdata('status') != "login"){
		redirect("login");
            }
	}
        
        function index()
        {
            $this->load->model('model_masterdagang');
            $master = $this->model_masterdagang->getalldagang()->result();
            $data['datamaster'] = $master;
            $this->load->view('master_dagangan',$data);
        }
        
        function inputmaster()
        {
            $this->load->view('input_masterdagang');
        }
        
        function inputmaster_save(){
            $this->load->model('model_masterdagang');
            $iddagang = strtoupper($this->input->post('idsupp')).'.'.strtoupper($this->input->post('iddagang'));
            if($this->input->post('komsel')=='ya'){
                $komsel = 'T';
            }else
            {
                $komsel = 'F';
            }
            if($this->input->post('pok')=='ya'){
                $pok = 'T';
            }else
            {
                $pok = 'F';
            }
            
            $datamaster = array(
                            'idsupp'=>strtoupper($this->input->post('idsupp')),
                            'iddagang'=>$iddagang,
                            'namadagang'=>strtoupper($this->input->post('namadagang')),
                            'deskripsi'=>strtoupper($this->input->post('deskripsi')),
                            'komsel'=>strtoupper($komsel),
                            'pok'=>strtoupper($pok)
                            );
                $res = $this->model_masterdagang->saveMaster($datamaster);
                $this->session->set_flashdata('result', $res);
                redirect('dagang');
        }
        
        function editmaster(){
            $this->load->model('model_masterdagang');
            $iddagang = $this->uri->segment(3);
            $data['datamaster'] = $this->model_masterdagang->getMaster($iddagang)->row_array();
            $this->load->view('edit_masterdagangan',$data);
        }
                
        function editmaster_save(){
            $this->load->model('model_masterdagang');
            $id = $this->input->post('id');
            if($this->input->post('komsel')=='ya'){
                $komsel = 'T';
            }else
            {
                $komsel = 'F';
            }
            $datamaster = array(
                        'namadagang'=>strtoupper($this->input->post('namadagang')),
                        'deskripsi'=>strtoupper($this->input->post('deskripsi')),
                        'komsel'=>strtoupper($komsel)
                    );
            $res = $this->model_masterdagang->updateMaster($id, $datamaster);
            $this->session->set_flashdata('result', $res);
            redirect('dagang');
        }
        
        public function search()
        {
             $this->load->model('model_mastersupplier');
             //if(isset($_GET['term'])){
             //   $nama = $_GET['term'];
                $this->model_mastersupplier->getsupplier();
             //}
        }
        
        public function searchq()
        {
             $this->load->model('model_mastersupplier');
             if(isset($_GET['term'])){
                $nama = strtoupper($_GET['term']);
                $this->model_mastersupplier->getsupplieqr($nama);
             }
        }
    }

