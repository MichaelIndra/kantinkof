<?php if (isset($error)){echo $error; } ?>
<?php echo form_open('supplier/inputmaster_save'); ?>
<table>
    <tr>
        <td>ID Supplier</td>
        <td><?php echo form_input('idsupp','',array('placeholder'=>'ID Supplier')); ?></td>
    </tr>
    <tr>
        <td>Nama Supplier</td>
        <td><?php echo form_input('namasupp','',array('placeholder'=>'Nama Supplier')); ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td><?php echo form_input('alamat','',array('placeholder'=>'Alamat')); ?></td>
    </tr>
    <tr>
        <td>No HP</td>
        <td><?php echo form_input('notelp','',array('placeholder'=>'NO Telp')); ?></td>
    </tr>
    <tr>
        <td>No WA</td>
        <td><?php echo form_input('nowa','',array('placeholder'=>'NO WA')); ?></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo form_submit('submit','Simpan Master'); ?></td>
    </tr>
</table>
<?php echo form_close(); ?>

<?php echo anchor('supplier','Kembali ke Master Supplier'); ?>