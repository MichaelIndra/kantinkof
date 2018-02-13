<?php
    class model_masterdagang extends CI_Model{
        
        function getalldagang()
        {
            $this->db->select('supplier.nama, dagangan.iddagang, dagangan.namadagang, dagangan.deskripsi, dagangan.komsel');
            $this->db->from('dagangan');
            $this->db->join('supplier','dagangan.idsupp = supplier.idsupp');
            $get = $this->db->get();
            return $get;
        }
        
        function getMaster($iddagang)
        {
            return $this->db->get_where('dagangan',array('iddagang'=>$iddagang));
        }
        
        function saveMaster($data)
        {
            if(!$this->db->insert('dagangan',$data) )
            {
                $res = 'Ada kesalahan input data. Periksa kembali';
            }else
            {
                $res = 'Data berhasil diinput';
            }
            return $res;
        }
        
        function updateMaster($kunci, $data)
        {
            $this->db->where('iddagang',$kunci);
            $this->db->update('dagangan',$data);
            if ($this->db->affected_rows()>0)
            {
                $result = 'Data berhasil diedit';
            }  else {
                $result = 'Data tidak berhasil di edit. Mohon periksa kembali';
            }
            return $result;
        }
        
        function getsearch()
        {
            $this->db->select('supplier.nama, dagangan.iddagang, dagangan.namadagang, supplier.idsupp');
            $this->db->from('dagangan');
            $this->db->join('supplier','dagangan.idsupp = supplier.idsupp');
            $get = $this->db->get();
            if($get->num_rows()>0){
                foreach ($get->result_array() as $row){
                    $rowset[] = $row;
                }
                echo json_encode($rowset);
            }
            return $get;
        }
        
    }
