<?php
    class rekapkof extends CI_Controller{
        function __construct(){
            parent::__construct();
	
            if($this->session->userdata('status') != "login"){
		redirect("login");
            }
	}
        
        function index(){
            $this->load->model('model_rekapkof');
            $tgl=$this->model_rekapkof->gettanggal();
            $data['tgl'] = $tgl;
            $this->load->view('rekap_kof', $data);
        }
        
        function rekap(){
            $this->load->model('model_rekapkof');
            $tgl = $this->input->post('tglrekap');
            $biayalain = $this->input->post('biayalain');
            $this->model_rekapkof->rekap($tgl, $this->session->userdata("komsel"), $biayalain);
            redirect('rekapkof');
        }
        
        public function ajax_list()
        {
            $this->load->model('model_rekapkof');
            $list = $this->model_rekapkof->get_datatables()->result();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $data) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $data->komsel;
                $row[] = $data->tanggal;
                $row[] = $data->totalhpp;
                $row[] = $data->totaljual;
                $row[] = $data->laba;
                $row[] = $data->totaldiskon;
                $row[] = $data->totalpok;
                $row[] = $data->biayalain;
                $row[] = $data->lababersih;
                $row[] = $data->nobukti;
                
                $datajd[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->model_rekapkof->count_all(),
                            "recordsFiltered" => $this->model_rekapkof->count_filtered(),
                            "data" => $datajd,
                    );
            //output to json format
            echo json_encode($output);
        }
        
    }
