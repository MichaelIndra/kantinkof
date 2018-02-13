<?php
        class transaksikof extends CI_Controller{
        function __construct(){
            parent::__construct();
            /*
            if($this->session->userdata('status') != "login"){
		redirect("login");
            }*/
	}    
            
        function index()
        {
            $this->load->model('model_transaksikof');
            $res = $this->model_transaksikof->getalltransaksi()->result();
            $data['datamaster'] = $res;
            $this->load->view('transaksi', $data);
        }
        
        public function transaksiresult(){
            $this->load->view('transaksiresult');
        }
        
        public function ajax_list_byDate()
        {
            $this->load->model('model_transaksikof');
            $list = $this->model_transaksikof->_get_datatables_query_date('2017-08-22')->result();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $data) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $data->nama;
                $row[] = $data->namadagang;
                $row[] = $data->stokawal;
                $row[] = $data->pok;
                $row[] = $data->stokjual;
                $row[] = $data->stokakhir;
                $row[] = $data->hargahpp;
                $row[] = $data->hargajual;
                $row[] = $data->totalhpp;
                $row[] = $data->totaljual;
                $row[] = $data->tanggal;
                $row[] = $data->idsupp;
                $row[] = $data->iddagang;

                $datajd[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->model_transaksikof->count_all(),
                            "recordsFiltered" => $this->model_transaksikof->count_filtered(),
                            "data" => $datajd,
                    );
            //output to json format
            echo json_encode($output);
        }
        
        function inputstok()
        {
            $this->load->view('inputstok');
        }
        
        function search()
        {
            $this->load->model('model_masterhargadagang');
            $res = $this->model_masterhargadagang->getallhargadagangaktif();
            if($res->num_rows()>0){
                foreach ($res->result_array() as $row)
                {
                    $rowset[]=$row;
                }
                echo json_encode($rowset);
            }
        }
        
        function inputstokawal()
        {
            $this->load->model('model_transaksikof');
            $data =array(
                'idsupp' =>$this->input->post('idsuplier'),
                'iddagang' => $this->input->post('iddagang'),
                'stokawal' => (int)$this->input->post('stokawal'),
                'stokakhir' => 0,
                'stokjual' => 0,
                'tanggal' => $this->input->post('tanggal'),
                'hargahpp' => $this->input->post('hargahpp'),
                'hargajual' => $this->input->post('hargajual'),
                'rekap'=>'T'
                
            );
            $res = $this->model_transaksikof->inputstokawal($data);
            $this->session->set_flashdata('result', $res);
            redirect('transaksikof');
        }
        function viewrekap()
        {
            $this->load->model('model_transaksikof');
            $res = $this->model_transaksikof->gettglbelumrekap();
            
                $data['tgl'] = $res;
            
            $this->load->view('rekap_transaksi',$data);
        }
        function coba(){
            $this->load->model('model_transaksikof');
            $res = $this->model_transaksikof->gettglbelumrekap();
            print_r($res);
        }
        
        function rekapbytanggal(){
            $this->load->model('model_transaksikof');
            $tglrekap = $this->input->post('tglrekap');
            $res =($this->model_transaksikof->rekapbytanggal($tglrekap));
            $this->session->set_flashdata('result', $res);
            redirect('transaksikof');
        }
        
        public function ajax_list()
        {
            $this->load->model('model_transaksikof');
            $list = $this->model_transaksikof->get_datatables()->result();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $data) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $data->nama;
                $row[] = $data->namadagang;
                $row[] = $data->stokawal;
                $row[] = $data->pok;
                $row[] = $data->stokjual;
                $row[] = $data->stokakhir;
                $row[] = $data->hargahpp;
                $row[] = $data->hargajual;
                $row[] = $data->totalhpp;
                $row[] = $data->totaljual;
                $row[] = $data->tanggal;
                $row[] = $data->idsupp;
                $row[] = $data->iddagang;

                $datajd[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->model_transaksikof->count_all(),
                            "recordsFiltered" => $this->model_transaksikof->count_filtered(),
                            "data" => $datajd,
                    );
            //output to json format
            echo json_encode($output);
        }
    }