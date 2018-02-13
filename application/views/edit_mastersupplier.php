<?php echo form_open('supplier/editmaster_save'); ?>
<?php echo form_hidden('id',$this->uri->segment(3)); ?>
<table>
    <tr>
        <td>ID Supplier</td>
        <td><?php echo form_input('idsupp',$datamaster['idsupp'],array('placeholder'=>'ID Supplier','disabled'=>'true')); ?></td>
    </tr>
    <tr>
        <td>Nama Supplier</td>
        <td><?php echo form_input('namasupp',$datamaster['nama'],array('placeholder'=>'Nama Supplier')); ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td><?php echo form_input('alamat',$datamaster['alamat'],array('placeholder'=>'Alamat')); ?></td>
    </tr>
    <tr>
        <td>No Telepon</td>
        <td><?php echo form_input('notelp',$datamaster['notelp'],array('placeholder'=>'NO Telp')); ?></td>
    </tr>
    <tr>
        <td>No WA</td>
        <td><?php echo form_input('nowa',$datamaster['nowa'],array('placeholder'=>'NO WA')); ?></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo form_submit('submit','Simpan Master'); ?></td>
    </tr>
</table>
<?php echo form_close(); ?>

<?php echo anchor('supplier','Kembali ke Master Supplier'); ?>
