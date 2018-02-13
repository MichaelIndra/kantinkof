<!DOCTYPE html>
<html lang="en">

<head>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-1.12.4.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.ui.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.easy-autocomplete.min.js'></script>

<link href='<?php echo base_url();?>assets/css/jquery.css' rel='stylesheet' />
<link href='<?php echo base_url();?>assets/css/easy-autocomplete.min.css' rel='stylesheet' />
</head>

<body>
<?php echo form_open('transaksikof/rekapbytanggal'); ?>
<table>
    <tr>
        <td>Pilih tanggal </td>
        <td><select name ="tglrekap"><?php
            foreach ($tgl as $r)
            {
                echo '<option value ="'.$r['tanggal'].'">'.$r['tanggal'].'</option>';
            }
            
            ?></select></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo form_submit('submit','Rekap Transaksi'); ?></td>
    </tr>
</table>
<?php echo form_close(); ?>
</body>
</html>