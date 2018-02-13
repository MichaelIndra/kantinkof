<?php
    class model_masterhargadagang extends CI_Model{
        //var $table = 'vtransaksi';
        var $column_order = array(null, 'supplier.nama','dagangan.namadagang'); //set column field database for datatable orderable
        var $column_search = array('supplier.nama','dagangan.namadagang'); //set column field database for datatable searchable 
        var $order = array('nama' => 'asc'); // default order 
        
        function getallhargadagangaktif(){
            $this->db->select('supplier.nama, supplier.idsupp, hargadagang.iddagang, dagangan.namadagang, hargadagang.hargahpp, hargadagang.hargajual, hargadagang.tglawal, hargadagang.tglakhir');
            $this->db->from('dagangan');
            $this->db->join('supplier','dagangan.idsupp = supplier.idsupp');
            $this->db->join('hargadagang','hargadagang.iddagang = dagangan.iddagang');
            $this->db->where('hargadagang.tglakhir is NULL', null, false);
            $get = $this->db->get();
            return $get;
        }
        
        function getallhargadagang(){
            $this->db->select('supplier.nama, hargadagang.iddagang, dagangan.namadagang, hargadagang.hargahpp, hargadagang.hargajual, hargadagang.tglawal, hargadagang.tglakhir');
            $this->db->from('dagangan');
            $this->db->join('supplier','dagangan.idsupp = supplier.idsupp');
            $this->db->join('hargadagang','hargadagang.iddagang = dagangan.iddagang');
            $get = $this->db->get();
            return $get;
        }
        
        function getdatahargabarang($iddagang, $tglawal){
            $this->db->select('supplier.nama, hargadagang.iddagang, dagangan.namadagang, hargadagang.hargahpp, hargadagang.hargajual, hargadagang.tglawal, hargadagang.tglakhir');
            $this->db->from('dagangan');
            $this->db->join('supplier','dagangan.idsupp = supplier.idsupp');
            $this->db->join('hargadagang','hargadagang.iddagang = dagangan.iddagang');
            $this->db->where('hargadagang.iddagang', $iddagang);
            $this->db->where('hargadagang.tglawal', $tglawal);
            $get = $this->db->get();
            return $get->row_array();
        }
        
        function savemaster($data){
            $result ='';
            $spliter = explode(',', $this->gettglakhir($data['iddagang']));
            if ($spliter[0] == 1)
            {
                //aktif
                $dateawal  =new DateTime($spliter[1]);
                $dateakhir = new DateTime($data['tglawal']);
                $dateakhir->modify('-1 day');
                if($dateawal>$dateakhir)
                {
                    $result = 'Tanggal awal lebih besar dari tanggal akhir '.$dateawal->format('Y-m-d').' vs '.$dateakhir->format('Y-m-d');
                    
                }else{
                    $tglakhir = $dateakhir->format('Y-m-d');
                    $this->isitglakhir($data['iddagang'], $tglakhir);
                    $this->db->insert('hargadagang',$data);
                    $result = 'Data sebelumnya aktif sehingga dinonaktifkan otomatis';
                }
            }else
            {
                $this->db->insert('hargadagang',$data);
                $result = 'Berhasil input data baru';
                //ga ada
            }
            
            return $result;
        }
        
        function gettglakhir($iddagang)
        {
            $this->db->where('iddagang', $iddagang);
            $this->db->where('tglakhir is NULL', null, false);
            $data = $this->db->get('hargadagang')->row_array();
            $res = $this->db->affected_rows().','.$data['tglawal'];
            return $res;
        }
        
        function isitglakhir($iddagang, $tglakhir){
            $this->db->where('iddagang', $iddagang);
            $this->db->where('tglakhir is NULL', null, false);
            $this->db->update('hargadagang',array('tglakhir'=>$tglakhir));
        }
        
        function updatetglakhir($iddagang, $tglawal, $tglakhir){
            $data = array('tglakhir'=>$tglakhir);
            $this->db->where('iddagang', $iddagang);
            $this->db->where('tglawal', $tglawal);
            $this->db->update('hargadagang',$data);
        }
        
        private function _get_datatables_query()
        {

            $this->db->select('supplier.nama, supplier.idsupp, hargadagang.iddagang, dagangan.namadagang, hargadagang.hargahpp, hargadagang.hargajual, hargadagang.tglawal, hargadagang.tglakhir');
            $this->db->from('dagangan');
            $this->db->join('supplier','dagangan.idsupp = supplier.idsupp');
            $this->db->join('hargadagang','hargadagang.iddagang = dagangan.iddagang');
            $this->db->where('hargadagang.tglakhir is NULL', null, false);

            $i = 0;

            foreach ($this->column_search as $item) // loop column 
            {
                if($_POST['search']['value']) // if datatable send POST for search
                {

                    if($i===0) // first loop
                    {
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }

                    if(count($this->column_search) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }

            if(isset($_POST['order'])) // here order processing
            {
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order))
            {
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }

        function get_datatables()
        {
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query;
        }

        function count_filtered()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function count_all()
        {
            $this->db->select('supplier.nama, supplier.idsupp, hargadagang.iddagang, dagangan.namadagang, hargadagang.hargahpp, hargadagang.hargajual, hargadagang.tglawal, hargadagang.tglakhir');
            $this->db->from('dagangan');
            $this->db->join('supplier','dagangan.idsupp = supplier.idsupp');
            $this->db->join('hargadagang','hargadagang.iddagang = dagangan.iddagang');
            $this->db->where('hargadagang.tglakhir is NULL', null, false);
            return $this->db->count_all_results();
        }
        
    }