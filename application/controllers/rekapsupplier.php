<?php

    class rekapsupplier extends CI_Controller{
        function __construct(){
            parent::__construct();
	
            if($this->session->userdata('status') != "login"){
		redirect("login");
            }
	}
        
        function index(){
            
            $this->load->view('rekap_supplier');
        }
        
        function rekapsupp(){
            $this->load->model('model_rekapsupplier');
            $query = $this->model_rekapsupplier->getsuppbelumrekap()->result_array();
            $data['supp'] = $query;
            $this->load->view('rekap_supp_satu',$data);
        }
        
        function rekapbytanggal(){
            $this->load->model('model_rekapsupplier');
            $data = $this->input->post('supp');
            $diskon = $this->input->post('diskon');
            $pok = $this->input->post('pok');
            $arr = explode('||', $data);
            $idsupp = $arr[0];
            $tgl = $arr[1];
            $nama = $arr[2];
            $this->model_rekapsupplier->rekapsupp($idsupp, $tgl, $diskon, $pok);
            redirect('rekapsupplier');
        }
        
        public function ajax_list()
        {
            $this->load->model('model_rekapsupplier');
            $list = $this->model_rekapsupplier->get_datatables()->result();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $data) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $data->noinvoice;
                $row[] = $data->nama;
                $row[] = $data->totalhpp;
                $row[] = $data->diskon;
                $row[] = $data->totalhppnet;
                $row[] = $data->tanggal;
                $row[] = $data->print;
                $row[] = $data->noinvoice.'-'.$data->print;
                
                $datajd[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->model_rekapsupplier->count_all(),
                            "recordsFiltered" => $this->model_rekapsupplier->count_filtered(),
                            "data" => $datajd,
                    );
            //output to json format
            echo json_encode($output);
        }
        
    }