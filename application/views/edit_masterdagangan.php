<?php echo form_open('dagang/editmaster_save'); ?>
<?php echo form_hidden('id',$this->uri->segment(3)); ?>
<table>
    <tr>
        <td>Nama Supplier</td>
        <td><?php echo form_input('idsupp',$datamaster['idsupp'],array('placeholder'=>'ID Supplier','disabled'=>'true')); ?></td>
    </tr>
    <tr>
        <td>ID Dagang</td>
        <td><?php echo form_input('iddagang',$datamaster['iddagang'],array('placeholder'=>'ID Dagang','disabled'=>'true')); ?></td>
    </tr>
    <tr>
        <td>Nama Dagang</td>
        <td><?php echo form_input('namadagang',$datamaster['namadagang'],array('placeholder'=>'Nama Dagangan')); ?></td>
    </tr>
    <tr>
        <td>Deskripsi</td>
        <td><?php echo form_input('deskripsi',$datamaster['deskripsi'],array('placeholder'=>'Deskripsi dagangan')); ?></td>
    </tr>
    <tr>
        <td>Komsel</td>
        <td><?php if($datamaster['komsel'] =='Y') {$bol = TRUE;}else{$bol = FALSE;} echo form_checkbox('komsel','ya', $bol); ?>(Yang masuk ke kas komsel)</td>
    </tr>
    <tr>
        <td colspan="2"><?php echo form_submit('submit','Simpan Master'); ?></td>
    </tr>
</table>
<?php echo form_close(); ?>

<?php echo anchor('dagang','Kembali ke Dagangan'); ?>
