<?php
    class model_webservice extends CI_Model{
        function getalldatabarang(){
            $this->db->select("transaksi.idsupp, transaksi.iddagang, transaksi.tanggal, transaksi.stokawal,"
                    . "transaksi.hargajual, dagangan.namadagang, dagangan.komsel, supplier.nama, dagangan.komsel, dagangan.pok");
            $this->db->from('transaksi');
            $this->db->join('dagangan','transaksi.iddagang = dagangan.iddagang');
            $this->db->join('supplier','transaksi.idsupp = supplier.idsupp');
            $this->db->where('transaksi.rekap','T');
            $get = $this->db->get()->result_array();
            return $get;
        }
        
        function insertdata($data){
            if(!$this->db->insert('detailtransaksi',$data))
            {
                $result = 'Insert detail transaksi gagal';
            }else
            {
                $result = 'Insert detail transaksi berhasil';
            }
            return $result;
        }
        
        function getalluser(){
            return $this->db->get('user')->result_array();
        }
    }