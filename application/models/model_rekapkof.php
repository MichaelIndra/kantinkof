<?php
    class model_rekapkof extends CI_Model{
        var $table = 'rekapkof';
        var $column_order = array('komsel','tanggal','nobukti'); //set column field database for datatable orderable
        var $column_search = array('komsel'); //set column field database for datatable searchable 
        var $order = array('komsel' => 'asc'); // default order
        
        function gettanggal()
        {
            $this->db->select('tanggal');
            $this->db->where('rekapkof','F');
            $this->db->group_by('tanggal');
            return $this->db->get('rekapsuplier')->result_array();
        }
        
        function rekap($tgl, $komsel, $biayalain)
        {
            $datetime = new DateTime();
            $tglskg = $datetime->format('Y-m-d');
            
            $totalpok = $this->gettotalpok($tgl);
            foreach ($totalpok as $r)
            {
                $pok = $r['totalpok'];
            }
            
            $totalhppjual = $this->gettotalhppjual($tgl);
            foreach ($totalhppjual as $r)
            {
                $hrgsupp = $r['hargaawal'];
                $hrgjual = $r['hargajual'];
                $laba    = $r['bathi'];
            }
            
            $totaldiskon = $this->getdiskon($tgl);
            foreach($totaldiskon as $r)
            {
                $ttldiskon = $r['diskon'];
            }
            
            $lababersih = ($laba+$ttldiskon)-$biayalain;
            
            $count = $this->getcounter($komsel);
            foreach ($count as $r)
            {
                $nocount = $r['no'];
            }
            
            $nobukti = $nocount.'/'.$komsel.'/'.$tglskg;
            $data = array(
                'komsel'=>$komsel, 
                'tanggal'=>$tglskg,
                'totalhpp'=>$hrgsupp,
                'totaljual'=>$hrgjual,
                'laba'=>$laba,
                'totaldiskon'=>$ttldiskon,
                'totalpok'=>$pok,
                'biayalain'=>$biayalain,
                'lababersih'=>$lababersih,
                'nobukti'=>$nobukti
                    );
            $this->db->insert('rekapkof',$data);
            $this->load->model('model_rekapsupplier');
            $this->model_rekapsupplier->updatecounter($komsel);
            $this->updaterekapsupplier($tgl, $nobukti);
        }
        
        function gettotalhppjual($tgl)
        {
            $where= array('tanggal'=>$tgl, 'rekap'=>'R');
            $this->db->select('sum((stokjual*hargahpp)) hargaawal, sum((stokjual*hargajual)) hargajual, sum((stokjual*hargajual)) - sum((stokjual*hargahpp)) bathi ', FALSE);
            $this->db->where($where);
            $this->db->group_by('tanggal');
            return $this->db->get('transaksi')->result_array();
        }
        
        function gettotalpok($tgl)
        {
            $where= array('tanggal'=>$tgl, 'rekap'=>'R');
            $this->db->select('sum(pok*hargahpp) as totalpok', FALSE);
            $this->db->where($where);
            $this->db->group_by('tanggal');
            return $this->db->get('transaksi')->result_array();
        }
        
        function getdiskon($tgl)
        {
            $this->db->select('sum(diskon) as diskon', FALSE);
            $this->db->where('rekapkof','F');
            $this->db->where('tanggal',$tgl);
            $this->db->group_by('tanggal');
            return $this->db->get('rekapsuplier')->result_array();
        }
        
        function getcounter($komsel)
        {
            $this->db->select('no');
            $this->db->where('invoice',$komsel);
            return $this->db->get('counter')->result_array();
        }
        
        function updaterekapsupplier($tgl, $nobukti)
        {
            
            $this->db->set('rekapkof','T');
            $this->db->set('nobukti',$nobukti);
            $this->db->where('rekapkof','F');
            $this->db->where('tanggal',$tgl);
            $this->db->update('rekapsuplier');
        }
        
        private function _get_datatables_query()
        {

            $this->db->from($this->table);
            
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
            $this->db->from($this->table);
            
            return $this->db->count_all_results();
        }
        
    }