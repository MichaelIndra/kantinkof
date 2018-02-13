<?php
	class supplier extends CI_Controller
	{
            function __construct(){
                parent::__construct();

                if($this->session->userdata('status') != "login"){
                    redirect("login");
                }
            }
		function index(){
                    $this->load->model('model_mastersupplier');
                    $master = $this->model_mastersupplier->getAllMaster()->result();
                    $data['datamaster'] = $master;
                    $this->load->view('master_supplier',$data);
                }
                
                function inputmaster(){
                    $this->load->view('input_mastersupplier');
                }
                
                function inputmaster_save(){
                    $this->load->model('model_mastersupplier');
                    $datamaster = array(
                                'idsupp'=>strtoupper($this->input->post('idsupp')),
                                'nama'=>strtoupper($this->input->post('namasupp')),
                                'alamat'=>strtoupper($this->input->post('alamat')),
                                'notelp'=>strtoupper($this->input->post('notelp')),
                                'nowa'=>strtoupper($this->input->post('nowa'))
                            );
                    $res = $this->model_mastersupplier->saveMaster($datamaster);
                    if($res == 1){
                        redirect('supplier');
                    }  else {
                        $message['error'] = 'Ada data yang sama dengan id '.strtoupper($this->input->post('idsupp')).'. Mohon periksa kembali';
                        $this->load->view('input_mastersupplier',$message);
                    }
                }
                
                function editmaster(){
                    $this->load->model('model_mastersupplier');
                    $idsupp = $this->uri->segment(3);
                    $data['datamaster'] = $this->model_mastersupplier->getMaster($idsupp)->row_array();
                    $this->load->view('edit_mastersupplier',$data);
                }
                
                function editmaster_save(){
                    $this->load->model('model_mastersupplier');
                    $id = $this->input->post('id');
                    $datamaster = array(
                                'nama'=>strtoupper($this->input->post('namasupp')),
                                'alamat'=>strtoupper($this->input->post('alamat')),
                                'notelp'=>strtoupper($this->input->post('notelp')),
                                'nowa'=>strtoupper($this->input->post('nowa'))
                            );
                    $this->db->where('idsupp',$id);
                    $this->db->update('supplier',$datamaster);
                    redirect('supplier');
                }
                
                
	}
