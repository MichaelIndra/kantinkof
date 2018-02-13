<!DOCTYPE html>
<html>
    <head> 
        <title>Transaksi</title>
        <script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-1.8.2.min.js'></script>
        <script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.autocomplete.js'></script>
        <script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.easy-autocomplete.min.js'></script>
        
        
        <link href='<?php echo base_url();?>assets/js/jquery.autocomplete.css' rel='stylesheet' />
        <link href='<?php echo base_url();?>assets/css/easy-autocomplete.min.css' rel='stylesheet' />
        <link href='<?php echo base_url();?>assets/DataTables/media/css/jquery.dataTables.min.css' rel='stylesheet' />
    </head>
    <body>
        <?php if ($this->session->flashdata('result')!= null){echo $this->session->flashdata('result').'<hr>'; } ?>
        <?php echo anchor('transaksikof/inputstok','Input Stok Awal'); ?> <?php echo anchor('transaksikof/viewrekap','Rekap Dagang'); ?>
        <table id ="table" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Nama Dagangan</th>
                    <th>Stok Awal</th>
                    <th>Pok</th>
                    <th>Stok Jual</th>
                    <th>Stok Akhir</th>
                    <th>Harga HPP</th>
                    <th>Harga Jual</th>
                    <th>Total HPP</th>
                    <th>Total Jual</th>
                    <th>Tanggal</th>
                    <th>ID Supplier</th>
                    <th>ID Dagang</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Nama Dagangan</th>
                    <th>Stok Awal</th>
                    <th>Pok</th>
                    <th>Stok Jual</th>
                    <th>Stok Akhir</th>
                    <th>Harga HPP</th>
                    <th>Harga Jual</th>
                    <th>Total HPP</th>
                    <th>Total Jual</th>
                    <th>Tanggal</th>
                    <th>ID Supplier</th>
                    <th>ID Dagang</th>
                </tr>
            </tfoot>>
            
            <!--
            <?php/* 
                foreach ($datamaster as $dm) {
                    echo '<tr>';
                    echo '<td>'.$dm->tanggal.'</td>';
                    echo '<td>'.$dm->nama.'</td>';
                    echo '<td>'.$dm->namadagang.'</td>';
                    echo '<td>'.$dm->stokawal.'</td>';
                    echo '<td>'.$dm->stokjual.'</td>';
                    echo '<td>'.$dm->stokakhir.'</td>';
                    echo '<td>'.$dm->hargahpp.'</td>';
                    echo '<td>'.$dm->hargajual.'</td>';
                    echo '<td>'.$dm->totalhpp.'</td>';
                    echo '<td>'.$dm->totaljual.'</td>';
                    echo'</tr>';
                }
             * 
             */
            ?>
            -->
            
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
                    "url": "<?php echo site_url('transaksikof/ajax_list')?>",
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
