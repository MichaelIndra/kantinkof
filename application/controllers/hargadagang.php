<?php
    class hargadagang extends CI_Controller{
        function __construct(){
            parent::__construct();
	
            if($this->session->userdata('status') != "login"){
		redirect("login");
            }
	}
        
        function index(){
            $this->load->model("model_masterhargadagang");
            $res =$this->model_masterhargadagang->getallhargadagangaktif()->result();
            $data['datamaster'] = $res;
            $this->load->view("master_hargadagang",$data);
        }
        
        function allhargadagang(){
            $this->load->model("model_masterhargadagang");
            $res =$this->model_masterhargadagang->getallhargadagang()->result();
            $data['datamaster'] = $res;
            $this->load->view("master_allhargadagang",$data);
        }
        
        function inputmaster(){
            $this->load->view("input_masterhargadagang");
        }
        
        function inputmaster_save(){
            $this->load->model('model_masterhargadagang');
            $datamaster = array(
                        'iddagang'=>strtoupper($this->input->post('iddagang')),
                        'hargahpp'=>$this->input->post('hargahpp'),
                        'hargajual'=>$this->input->post('hargajual'),
                        'tglawal'=>$this->input->post('tglawal')
                    );
            
            $result = $this->model_masterhargadagang->saveMaster($datamaster);
            $this->session->set_flashdata('result', $result); 
            redirect('hargadagang');
        }
        
        function nonaktif()
        {
            $this->load->model('model_masterhargadagang');
            $iddagang = strtoupper($this->uri->segment(3));
            $tglawal = $this->uri->segment(4);
            $data['hasil'] = $this->model_masterhargadagang->getdatahargabarang($iddagang, $tglawal);
            $this->load->view("nonaktif_hargadagang", $data);
        }
        
        function nonaktif_update(){
            $this->load->model('model_masterhargadagang');
            $iddagang = strtoupper($this->input->post('iddagang'));
            $tglawal = $this->input->post('tglawal');
            $tglakhir = $this->input->post('tglakhir');
            if ($this->cektanggal($tglawal, $tglakhir))
            {
                $this->session->set_flashdata('result', 'Nonaktif berhasil');
                $this->model_masterhargadagang->updatetglakhir($iddagang, $tglawal, $tglakhir);
            }  else {
                $result = 'Nonaktif gagal, karena '.$tglawal.' lebih besar dari '.$tglakhir;
                $this->session->set_flashdata('result', $result);
            }
            redirect('hargadagang');
        }
        
        function cektanggal($tglawal, $tglakhir)
        {
            $dateawal  =new DateTime($tglawal);
            $dateakhir = new DateTime($tglakhir);
            if($dateawal>$dateakhir)
            {
                return FALSE;

            }  else {
                return TRUE;
            }
        }
        
        function search()
        {
            $this->load->model('model_masterdagang');
            $this->model_masterdagang->getsearch();
        }
        
        public function ajax_list()
        {
            $this->load->model('model_masterhargadagang');
            $list = $this->model_masterhargadagang->get_datatables()->result();
            $data = array();
            $no = $_POST['start'];
            //$ancor = ''
            foreach ($list as $data) {
                
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $data->nama;
                $row[] = $data->iddagang;
                $row[] = $data->namadagang;
                $row[] = $data->hargahpp;
                $row[] = $data->hargajual;
                $row[] = $data->tglawal;
                $row[] = anchor('hargadagang/nonaktif/'.$data->iddagang.'/'.$data->tglawal,'Nonaktifkan');
                

                $datajd[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->model_masterhargadagang->count_all(),
                            "recordsFiltered" => $this->model_masterhargadagang->count_filtered(),
                            "data" => $datajd,
                    );
            //output to json format
            echo json_encode($output);
        }
        
    }