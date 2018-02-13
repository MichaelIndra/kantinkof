<!DOCTYPE html>
<html lang="en">

<head>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-1.8.2.min.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.autocomplete.js'></script>

<!-- Memanggil file .css untuk style saat data dicari dalam filed -->
<link href='<?php echo base_url();?>assets/js/jquery.autocomplete.css' rel='stylesheet' />

<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.easy-autocomplete.min.js'></script>
<link href='<?php echo base_url();?>assets/css/easy-autocomplete.min.css' rel='stylesheet' />



<!-- Memanggil file .css autocomplete_ci/assets/css/default.css -->


    <script type='text/javascript'>
        $(document).ready(function(){
        var option ={
            url : "<?php echo site_url('dagang/search');?>",
            getValue : "nama",
            list:{
                match:{enabled:true},
                onSelectItemEvent: function() {
			var value = $("#autocomplete").getSelectedItemData().idsupp;

			$("#idsupp").val(value).trigger("change");
		}
            }
        };
        $("#autocomplete").easyAutocomplete(option);
        
        /*var site = "<?php echo site_url();?>";
        $(function(){
            $('#autocomplete').autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                    source: '<?php echo site_url('dagang/searchq/?');?>',
                    
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                select: function (event, suggestion) {
                    $('#idsupp').val(''+suggestion.idsupp); // membuat id 'v_nim' untuk ditampilkan
                    
                }
            });
        });*/
    });
    </script>
</head>
<body>    
<?php if (isset($error)){echo $error; } ?>
<?php echo form_open('dagang/inputmaster_save'); ?>
<table>
    <tr>
    
        
        <td>Nama Supplier</td>
        <td><input type="text" id="autocomplete" placeholder="nama supplier" name="namasupplier"/></td>
        <td><input type="hidden" id="idsupp" name="idsupp"/></td>
    </tr>
    <tr>
        <td>ID Dagang</td>
        <td><?php echo form_input('iddagang','',array('placeholder'=>'ID Dagang')); ?></td>
    </tr>
    <tr>
        <td>Nama Dagang</td>
        <td><?php echo form_input('namadagang','',array('placeholder'=>'Nama Dagangan')); ?></td>
    </tr>
    <tr>
        <td>Deskripsi</td>
        <td><?php echo form_input('deskripsi','',array('placeholder'=>'Deskripsi dagangan')); ?></td>
    </tr>
    <tr>
        <td>Komsel</td>
        <td><?php echo form_checkbox('komsel','ya',FALSE); ?>(Yang masuk ke kas komsel)</td>
    </tr>
    <tr>
        <td>Pok</td>
        <td><?php echo form_checkbox('pok','ya',FALSE); ?>(Yang termasuk pok)</td>
    </tr>
    <tr>
        <td colspan="2"><?php echo form_submit('submit','Simpan Master'); ?></td>
    </tr>
    
</table>
<?php echo form_close(); ?>

<?php echo anchor('dagang','Kembali ke Dagangan'); ?>

</body>
</html>