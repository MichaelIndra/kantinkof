<?php
    class Model_mastersupplier extends CI_Model
    {
        function getAllMaster()
        {
            $supp = $this->db->get('supplier');
            return $supp;
        }
        
        function getMaster($idsupp)
        {
            return $this->db->get_where('supplier',array('idsupp'=>$idsupp));
        }
        
        function saveMaster($data)
        {
            if(!$this->db->insert('supplier',$data) )
            {
                $res = 0;
            }else
            {
                $res = $this->db->affected_rows();
            }
            return $res;
            
        }
        
        function updateMaster($kunci, $data)
        {
            $this->db->where('idsupp',$kunci);
            $this->db->update('supplier',$data);
            return $this->db->affected_rows();
        }
        
        function getsupplier()
        {
            $this->db->select("*");
            //$this->db->like('nama', $nama, 'both');
            $query = $this->db->get("supplier");
            if($query->num_rows()>0){
                foreach ($query->result_array() as $row){
                    $new_row['idsupp'] = $row['idsupp']; 
                    $new_row['nama'] = $row['nama']; 
                    $rowset[] = $new_row;
                }
                echo json_encode($rowset);
            }
        }
        
        function getsupplierq($nama)
        {
            $this->db->select("*");
            $this->db->like('nama', $nama, 'both');
            $query = $this->db->get("supplier");
            if($query->num_rows()>0){
                foreach ($query->result_array() as $row){
                    $new_row['idsupp'] = $row['idsupp']; 
                    $new_row['nama'] = $row['nama']; 
                    $rowset[] = $new_row;
                }
                echo json_encode($rowset);
            }
        }
        
    }

