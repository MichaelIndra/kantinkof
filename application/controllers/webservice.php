<?php
    class webservice extends CI_Controller{
        function getalldatabarang()
        {
            $this->load->model('model_webservice');
            echo '{"barang":'.json_encode($this->model_webservice->getalldatabarang()).'}';
        }
        
        function insertTransaksi(){
            $this->load->model('model_webservice');
            $response = array("error"=> FALSE);
            if(isset($_POST['notransaksi']) && isset($_POST['iddagang']) && isset($_POST['user'])
                    && isset($_POST['totalbeli']) && isset($_POST['totalharga']) && isset($_POST['tanggal'])
                    && isset($_POST['komsel']) && isset($_POST['rekap']) && isset($_POST['pok']))
            {
                $data=array(
                    "notransaksi"=>$_POST['notransaksi'],
                    "iddagang"=>$_POST['iddagang'],
                    "user"=>$_POST['user'],
                    "totalbeli"=>$_POST['totalbeli'],
                    "totalharga"=>$_POST['totalharga'],
                    "tanggal"=>$_POST['tanggal'],
                    "komsel"=>$_POST['komsel'],
                    "rekap"=>$_POST['rekap'],
                    "pok"=>$_POST['pok']
                );
               $response['msg'] = $this->model_webservice->insertdata($data);
               $response['sukses']="berhasil masuk"; 
            }  else {
                $response['error'] = TRUE;
                $response['error_msg'] = 'Ada parameter yg salah';
                echo json_encode($response);
            }
        }
        
        function getalluser(){
            $this->load->model('model_webservice');
            echo '{"user":'.json_encode($this->model_webservice->getalluser()).'}';
        }
        
    }

