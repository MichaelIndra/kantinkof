<?php
    class model_transaksikof extends CI_Model{
        var $table = 'vtransaksi';
        var $column_order = array(null, 'nama','namadagang','tanggal','idsupp','iddagang'); //set column field database for datatable orderable
        var $column_search = array('nama','namadagang'); //set column field database for datatable searchable 
        var $order = array('nama' => 'asc'); // default order 
        
        function getalltransaksi()
        {
            $this->db->select('supplier.nama, dagangan.namadagang, transaksi.stokawal, transaksi.pok, transaksi.stokjual, transaksi.stokakhir, hargadagang.hargahpp, hargadagang.hargajual'
                    . ', transaksi.totalhpp, transaksi.totaljual, transaksi.tanggal, transaksi.idsupp, transaksi.iddagang');
            $this->db->from('transaksi');
            $this->db->join('supplier','transaksi.idsupp = supplier.idsupp');
            $this->db->join('dagangan','transaksi.iddagang = dagangan.iddagang');
            $this->db->join('hargadagang','hargadagang.iddagang = dagangan.iddagang');
            $get = $this->db->get();
            return $get;
        }
        
        function inputstokawal($data)
        {
            if(!$this->db->insert('transaksi',$data))
            {
                $result = 'Insert stok awal gagal. Periksa kembali';
            }else
            {
                $result = 'Insert stok awal berhasil';
            }
            return $result;
        }
        
        function gettglbelumrekap()
        {
            $this->db->select('tanggal');
            $this->db->where('rekap','T');
            $this->db->group_by('tanggal');
            return $this->db->get('transaksi')->result_array();
        }
        
        function rekapbytanggal($tglrekap){
            $iddagang= $this->getiddagangbytanggal($tglrekap);
            $data ='Gagal melakukan rekap dagang';
            foreach ($iddagang as $r)
            {
                $stokjual = $this->getstokjual($tglrekap, $r['iddagang']);
                $pok =  $this->getpok($tglrekap, $r['iddagang']);
                $this->updatestokakhir($r['iddagang'], $tglrekap, $stokjual, $pok);
                $this->updatedetailtransaksi($tglrekap, $r['iddagang']);
                $data='Sukses melakukan rekap dagang';
            }
            return $data;
        }
        function getiddagangbytanggal($tglrekap){
            $this->db->select('transaksi.iddagang');
            $this->db->from('transaksi');
            $this->db->join('dagangan','transaksi.iddagang = dagangan.iddagang');
            $this->db->where('dagangan.komsel','F');
            $this->db->where('transaksi.rekap','T');
            $this->db->where('transaksi.tanggal',$tglrekap);
            return $this->db->get()->result_array();
        }
        
        function getstokjual($tglrekap, $iddagang){
            $this->db->select('SUM(totalbeli) as total', FALSE);
            $this->db->where('rekap','F');
            $this->db->where('pok','F');
            $this->db->where('tanggal',$tglrekap);
            $this->db->where('iddagang',$iddagang);
            $this->db->group_by('iddagang');
            $ret = $this->db->get('detailtransaksi');
            $count = $ret->num_rows();
            if($count >0){
                foreach ($ret->result_array() as $st)
                {
                    $total = $st['total'];
                }
            }  else {
                $total = 0;
            }
            return $total;
        }
        
        function getpok($tglrekap, $iddagang){
            $this->db->select('SUM(totalbeli) as total', FALSE);
            $this->db->where('rekap','F');
            $this->db->where('pok','T');
            $this->db->where('tanggal',$tglrekap);
            $this->db->where('iddagang',$iddagang);
            $this->db->group_by('iddagang');
            $ret = $this->db->get('detailtransaksi');
            $count = $ret->num_rows();
            if($count >0){
                foreach ($ret->result_array() as $st)
                {
                    $total = $st['total'];
                }
            }  else {
                $total = 0;
            }
            return $total;
        }
        
        function updatestokakhir($iddagang, $tglrekap, $stokjual, $pok)
        {
            $netstok = $stokjual+$pok;
            $stokakhir = '(stokawal-'.$netstok.')';
            $totalhpp = '('.$netstok.')*hargahpp';
            $totaljual = '('.$netstok.')*hargajual';
            
            $this->db->set('stokakhir',$stokakhir,FALSE);
            $this->db->set('stokjual',$stokjual,FALSE);
            $this->db->set('totalhpp',$totalhpp,FALSE);
            $this->db->set('totaljual',$totaljual,FALSE);
            $this->db->set('pok',$pok,FALSE);
            $this->db->set('rekap','Y');
            
            $this->db->where('tanggal',$tglrekap);
            $this->db->where('iddagang',$iddagang);
            $this->db->update('transaksi');
        }
        
        function updatedetailtransaksi($tglrekap, $iddagang)
        {
            $this->db->set('rekap','T');
            $this->db->where('rekap','F');
            $this->db->where('tanggal',$tglrekap);
            $this->db->where('iddagang',$iddagang);
            $this->db->update('detailtransaksi');
        }
        
        private function _get_datatables_query()
        {

            $this->db->select('supplier.nama, dagangan.namadagang, transaksi.stokawal, transaksi.pok, transaksi.stokjual, transaksi.stokakhir, hargadagang.hargahpp, hargadagang.hargajual'
                    . ', transaksi.totalhpp, transaksi.totaljual, transaksi.tanggal, transaksi.idsupp, transaksi.iddagang');
            $this->db->from('transaksi');
            $this->db->join('supplier','transaksi.idsupp = supplier.idsupp');
            $this->db->join('dagangan','transaksi.iddagang = dagangan.iddagang');
            $this->db->join('hargadagang','hargadagang.iddagang = dagangan.iddagang');
            $this->db->where('transaksi.rekap !=','R');
            //$this->db->where('transaksi.tanggal','2017-08-22');
            $this->db->where('hargadagang.tglakhir ','0000-00-00');
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
            $this->db->select('supplier.nama, dagangan.namadagang, transaksi.stokawal, transaksi.pok, transaksi.stokjual, transaksi.stokakhir, hargadagang.hargahpp, hargadagang.hargajual'
                    . ', transaksi.totalhpp, transaksi.totaljual, transaksi.tanggal, transaksi.idsupp, transaksi.iddagang');
            $this->db->from('transaksi');
            $this->db->join('supplier','transaksi.idsupp = supplier.idsupp');
            $this->db->join('dagangan','transaksi.iddagang = dagangan.iddagang');
            $this->db->join('hargadagang','hargadagang.iddagang = dagangan.iddagang');
            return $this->db->count_all_results();
        }
        
        
        
        public function _get_datatables_query_date($date)
        {

            $this->db->select('supplier.nama, dagangan.namadagang, transaksi.stokawal, transaksi.pok, transaksi.stokjual, transaksi.stokakhir, hargadagang.hargahpp, hargadagang.hargajual'
                    . ', transaksi.totalhpp, transaksi.totaljual, transaksi.tanggal, transaksi.idsupp, transaksi.iddagang');
            $this->db->from('transaksi');
            $this->db->join('supplier','transaksi.idsupp = supplier.idsupp');
            $this->db->join('dagangan','transaksi.iddagang = dagangan.iddagang');
            $this->db->join('hargadagang','hargadagang.iddagang = dagangan.iddagang');
            $this->db->where('transaksi.tanggal',$date);
            $this->db->where('hargadagang.tglakhir ','0000-00-00');
            $i = 0;
             /*
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
            }*/
        }

        function get_datatables_date()
        {
            $this->_get_datatables_query_date();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query;
        }

        function count_filtered_date()
        {
            $this->_get_datatables_query_date();
            $query = $this->db->get();
            return $query->num_rows();
        }
        
        
        
        
    }
