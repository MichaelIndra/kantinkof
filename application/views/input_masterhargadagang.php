<!DOCTYPE html>
<html lang="en">

<head>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-1.8.2.min.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.autocomplete.js'></script>

<link href='<?php echo base_url();?>assets/js/jquery.autocomplete.css' rel='stylesheet' />

<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.easy-autocomplete.min.js'></script>
<link href='<?php echo base_url();?>assets/css/easy-autocomplete.min.css' rel='stylesheet' />

    <script type='text/javascript'>
        $(document).ready(function(){
        var option ={
            url : "<?php echo site_url('hargadagang/search');?>",
            getValue : "namadagang",
            
            template :{
                type :"custom",
                method : function(value, item){
                            return item.namadagang + " || "+item.nama;
                        }
            },
            list:{
                match:{enabled:true},
                onSelectItemEvent: function() {
			var namasuplier = $("#namadagang").getSelectedItemData().nama;
			var idsupp = $("#namadagang").getSelectedItemData().idsupp;
			var iddagang = $("#namadagang").getSelectedItemData().iddagang;

			$("#namasuplier").val(namasuplier).trigger("change");
			$("#idsuplier").val(idsupp).trigger("change");
			$("#iddagang").val(iddagang).trigger("change");
		}
            }
        };
        $("#namadagang").easyAutocomplete(option);
    });
    </script>
</head>
<body>   
<?php if (isset($error)){echo $error; } ?>
<?php echo form_open('hargadagang/inputmaster_save'); ?>
<table>
    <tr>
        <td>ID Dagang</td>
        <td><input type="text" id="namadagang" placeholder="Nama Dagang"  /></td>
        <td><input type="text" id="namasuplier" disabled="disabled"/></td>
        <td><input type="hidden" name="idsuplier" id="idsuplier"  /></td>
        <td><input type="hidden" name="iddagang" id="iddagang"  /></td>
    </tr>
    <tr>
        <td>Harga HPP</td>
        <td><?php echo form_input('hargahpp','',array('placeholder'=>'Harga Jual')); ?></td>
    </tr>
    <tr>
        <td>Harga Jual</td>
        <td><?php echo form_input('hargajual','',array('placeholder'=>'Harga Jual')); ?></td>
    </tr>
    <tr>
        <td>Tanggal Aktif</td>
        <td><?php echo form_input('tglawal','',array('placeholder'=>'Tanggal Awal')); ?></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo form_submit('submit','Simpan Master'); ?></td>
    </tr>
</table>
<?php echo form_close(); ?>

<?php echo anchor('hargadagang','Kembali ke Master Harga Dagangan'); ?>
</body>
</html>