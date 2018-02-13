<!DOCTYPE html>
<html lang="en">

<head>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-1.12.4.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.ui.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.easy-autocomplete.min.js'></script>

<link href='<?php echo base_url();?>assets/css/jquery.css' rel='stylesheet' />
<link href='<?php echo base_url();?>assets/css/easy-autocomplete.min.css' rel='stylesheet' />

    <script type='text/javascript'>
        $(document).ready(function(){
        var option ={
            url : "<?php echo site_url('transaksikof/search');?>",
            getValue : "namadagang",
            
            template :{
                type :"custom",
                method : function(value, item){
                            return item.namadagang + " || "+item.nama+" || "+item.hargahpp;
                        }
            },
            list:{
                match:{enabled:true},
                onSelectItemEvent: function() {
			var namasuplier = $("#namadagang").getSelectedItemData().nama;
			var idsupp = $("#namadagang").getSelectedItemData().idsupp;
			var iddagang = $("#namadagang").getSelectedItemData().iddagang;
			var hargahpp = $("#namadagang").getSelectedItemData().hargahpp;
			var hargajual = ($("#namadagang").getSelectedItemData().hargajual);
                        
                        
                        
			$("#namasuplier").val(namasuplier).trigger("change");
			$("#idsuplier").val(idsupp).trigger("change");
			$("#iddagang").val(iddagang).trigger("change");
			$("#ihargahpp").val(hargahpp).trigger("change");
			$("#ihargajual").val(hargajual).trigger("change");
			$("#hargahpp").val(hargahpp).trigger("change");
			$("#hargajual").val(hargajual).trigger("change");
		}
            }
        };
        $("#namadagang").easyAutocomplete(option);
        $("#tglawal").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        
        
    });
    </script>
</head>
<body>    
    <?php echo form_open('transaksikof/inputstokawal'); ?>
    <table>
        <tr>
            <td>Nama Barang Dagang</td>
            <td><input type="text" id="namadagang" placeholder="Ketik nama dagang"/></td>
            <td><input type="text" id="namasuplier" placeholder="Nama Supplier" disabled="disabled"/></td>
            <td><input type="text" id="hargahpp" placeholder="Harga HPP" disabled="disabled"/></td>
            <td><input type="text" id="hargajual" placeholder="Harga Jual" disabled="disabled"/></td>
            <td><input type="hidden" name="idsuplier" id="idsuplier"  /></td>
            <td><input type="hidden" name="iddagang" id="iddagang"  /></td>
            <td><input type="hidden" name="hargahpp" id="ihargahpp"  /></td>
            <td><input type="hidden" name="hargajual" id="ihargajual"  /></td>
        </tr>
        <tr>
            <td>Stok Awal</td>
            <td><?php echo form_input('stokawal','',array('placeholder'=>'Stok Awal')); ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td><?php echo form_input('tanggal','',array('placeholder'=>'Tanggal Stok', 'id'=>'tglawal')); ?></td>
        </tr>
        <tr>
        <td colspan="2"><?php echo form_submit('submit','Simpan Stok'); ?></td>
    </tr>
    </table>
 <?php echo form_close(); ?>
       
</body>
</html>