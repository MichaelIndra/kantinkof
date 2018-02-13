<?php

    class model_rekapsupplier extends CI_Model{
        var $table = 'vrekapsuplier';
        var $column_order = array(null, 'noinvoice','nama','tanggal'); //set column field database for datatable orderable
        var $column_search = array('nama','noinvoice'); //set column field database for datatable searchable 
        var $order = array('nama' => 'asc'); // default order
        
       
        
        private function _get_datatables_query()
        {

            $this->db->select('supplier.nama, rekapsuplier.noinvoice, rekapsuplier.totalhppnet, rekapsuplier.totalhpp, rekapsuplier.diskon, rekapsuplier.tanggal, rekapsuplier.print');
            $this->db->from('rekapsuplier');
            $this->db->join('supplier','rekapsuplier.idsupp = supplier.idsupp');
            
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
            $this->db->select('supplier.nama, rekapsuplier.noinvoice, rekapsuplier.totalhppnet, rekapsuplier.totalhpp, rekapsuplier.diskon, rekapsuplier.tanggal, rekapsuplier.print');
            $this->db->from('rekapsuplier');
            $this->db->join('supplier','rekapsuplier.idsupp = supplier.idsupp');
            
            return $this->db->count_all_results();
        }
        
        function getsuppbelumrekap()
        {
            $this->db->select('supplier.nama, transaksi.idsupp, transaksi.tanggal');
            $this->db->from('transaksi');
            $this->db->join('supplier','transaksi.idsupp = supplier.idsupp');
            $this->db->where('rekap','Y');
            $this->db->group_by('transaksi.idsupp');
            return $this->db->get();
        }
        
        function rekapsupp($idsupp, $tgl, $diskon){
            $where= array('idsupp'=>$idsupp, 'tanggal'=>$tgl);
            $this->db->select('sum(totalhpp) as totalhpp');
            $this->db->from('transaksi');
            $this->db->where($where);
            $this->db->group_by('idsupp');
            $total = $this->db->get();
            foreach ($total->result_array() as $row)
            {
                $totalhpp = $row['totalhpp'];
                
            }
            $wcounter= array('invoice'=>'KOF');
            $this->db->select('no, invoice');
            $this->db->where($wcounter);
            $no = $this->db->get('counter')->result_array();
            foreach($no as $row)
            {
                $nocounter = $row['no'];
                $invoice = $row['invoice'];
            }
            $datetime = new DateTime();
            $tglskg = $datetime->format('Y-m-d');
            $noinvoice=$nocounter.'/'.$invoice.'/'.$tglskg;
            $totdiskon = ($diskon/100)*$totalhpp;
            
            $data['noinvoice']=$noinvoice;
            $data['idsupp']=$idsupp;
            $data['totalhpp'] =$totalhpp;
            $data['totalhppnet'] =$totalhpp-$totdiskon;
            $data['diskon'] =$totdiskon;
            $data['tanggal'] =$tglskg;
            $data['print'] ='F';
            $data['rekapkof'] ='F';
            $this->db->insert('rekapsuplier',$data);
            $this->updatetransaksi($idsupp, $tgl, $noinvoice);
            $this->updatecounter('KOF');
        }
        
        function updatetransaksi($idsupp, $tgl, $noinvoice)
        {
            $this->db->set('rekap','R');
            $this->db->set('noinvoice',$noinvoice);
            $this->db->where('rekap','Y');
            $this->db->where('tanggal',$tgl);
            $this->db->where('idsupp',$idsupp);
            $this->db->update('transaksi');
        }
        
        function updatecounter($invoice)
        {
            $counter = '(no+1)';
            $this->db->set('no',$counter,FALSE);
            $this->db->where('invoice',$invoice);
            $this->db->update('counter');
            
        }
        
    }
//SELECT sum((stokjual*hargahpp)) hargaawal, sum((stokjual*hargajual)) hargajual, sum((stokjual*hargajual)) - sum((stokjual*hargahpp)) bathi
//FROM `transaksi`
 