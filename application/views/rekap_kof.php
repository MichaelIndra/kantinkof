<html>
    <head> 
        <title>Rekap KOF</title>
        <script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-1.8.2.min.js'></script>
        <script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.autocomplete.js'></script>
        <script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.easy-autocomplete.min.js'></script>
        
        
        <link href='<?php echo base_url();?>assets/js/jquery.autocomplete.css' rel='stylesheet' />
        <link href='<?php echo base_url();?>assets/css/easy-autocomplete.min.css' rel='stylesheet' />
        <link href='<?php echo base_url();?>assets/DataTables/media/css/jquery.dataTables.min.css' rel='stylesheet' />
    </head>
    <body>
       <?php echo form_open('rekapkof/rekap'); ?>
        <table>
            <tr>
                <td>Pilih tanggal rekap kof</td>
                <td><select name ="tglrekap"><?php
            foreach ($tgl as $r)
            {
                echo '<option value ="'.$r['tanggal'].'">'.$r['tanggal'].'</option>';
            }
            
            ?></select></td>
                <td><?php echo form_input('biayalain','',array('placeholder'=>'Biaya lain-lain')); ?></td>
                <td><?php echo form_submit('submit','Rekap KOF'); ?></td>   
            </tr>
        </table>
        <?php echo form_close(); ?>
        
        <table id ="table" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Komsel</th>
                    <th>Tanggal</th>
                    <th>Total Penjualan Supplier</th>
                    <th>Total Penjualan KOF</th>
                    <th>Laba Kotor</th>
                    <th>Total Diskon Supplier</th>
                    <th>Total Pok</th>
                    <th>Biaya Lain</th>
                    <th>Laba Bersih</th>
                    <th>No Bukti</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Komsel</th>
                    <th>Tanggal</th>
                    <th>Total Penjualan Supplier</th>
                    <th>Total Penjualan KOF</th>
                    <th>Laba Kotor</th>
                    <th>Total Diskon Supplier</th>
                    <th>Total Pok</th>
                    <th>Biaya Lain</th>
                    <th>Laba Bersih</th>
                    <th>No Bukti</th>
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
                    "url": "<?php echo site_url('rekapkof/ajax_list')?>",
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