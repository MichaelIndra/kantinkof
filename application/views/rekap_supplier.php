<!DOCTYPE html>
<html>
    <head> 
        <title>Rekap Supplier</title>
        <script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-1.8.2.min.js'></script>
        <script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.autocomplete.js'></script>
        <script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.easy-autocomplete.min.js'></script>
        
        
        <link href='<?php echo base_url();?>assets/js/jquery.autocomplete.css' rel='stylesheet' />
        <link href='<?php echo base_url();?>assets/css/easy-autocomplete.min.css' rel='stylesheet' />
        <link href='<?php echo base_url();?>assets/DataTables/media/css/jquery.dataTables.min.css' rel='stylesheet' />
    </head>
    <body>
        <?php if ($this->session->flashdata('result')!= null){echo $this->session->flashdata('result').'<hr>'; } ?>
        <?php echo anchor('rekapsupplier/rekapsupp','Rekap supplier satu per satu'); ?>
        <table id ="table" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Nama Supplier</th>
                    <th>Total Penjualan Supplier</th>
                    <th>Diskon</th>
                    <th>Total Bayar Supplier</th>
                    <th>Tanggal</th>
                    <th>Print</th>
                    <th>Aksi Print</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Nama Supplier</th>
                    <th>Total Penjualan Supplier</th>
                    <th>Diskon</th>
                    <th>Total Bayar Supplier</th>
                    <th>Tanggal</th>
                    <th>Print</th>
                    <th>Aksi Print</th>
                </tr>
            </tfoot>>
            
        </table>
        <script type='text/javascript' src='<?php echo base_url();?>assets/DataTables/media/js/jquery.dataTables.min.js'></script>
        <script type="text/javascript">

        var table;

        $(document).ready(function() {

            //datatables
            table = $('#table').DataTable({ 

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('rekapsupplier/ajax_list')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                    "targets": [ 0 ], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                ],

            });

        });
        </script>
        <?php echo anchor('welcome','Kembali ke menu utama');?>
    </body>
</html>
