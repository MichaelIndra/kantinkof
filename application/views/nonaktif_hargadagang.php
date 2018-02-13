<?php if (isset($error)){echo $error; } ?>
<?php echo form_open('hargadagang/nonaktif_update'); ?>
<?php echo form_hidden('iddagang',$hasil['iddagang']); ?>
<?php echo form_hidden('tglawal',$hasil['tglawal']); ?>
<table>
    <tr>
        <td>Nama Supplier</td>
        <td><?php echo form_input('idsupp',$hasil['nama'],array('placeholder'=>'ID Supplier', 'id'=>'idpp','disabled'=>'disabled')); ?></td>
    </tr>
    <tr>
        <td>ID Dagang</td>
        <td><?php echo form_input('',$hasil['iddagang'],array('placeholder'=>'ID Dagang','disabled'=>'disabled')); ?></td>
    </tr>
    <tr>
        <td>Nama Dagang</td>
        <td><?php echo form_input('namadagang',$hasil['namadagang'],array('placeholder'=>'Nama Dagangan','disabled'=>'disabled')); ?></td>
    </tr>
    <tr>
        <td>Harga HPP</td>
        <td><?php echo form_input('hargahpp',$hasil['hargahpp'],array('placeholder'=>'Harga Jual','disabled'=>'disabled')); ?></td>
    </tr>
    <tr>
        <td>Harga Jual</td>
        <td><?php echo form_input('hargajual',$hasil['hargajual'],array('placeholder'=>'Harga Jual','disabled'=>'disabled')); ?></td>
    </tr>
    <tr>
        <td>Tanggal Aktif</td>
        <td><?php echo form_input('',$hasil['tglawal'],array('placeholder'=>'Tanggal Awal','disabled'=>'disabled')); ?></td>
    </tr>
    <tr>
        <td>Tanggal Non Aktif</td>
        <td><?php echo form_input('tglakhir','',array('placeholder'=>'Tanggal Akhir')); ?></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo form_submit('submit','Simpan Master'); ?></td>
    </tr>
</table>
<?php echo form_close(); ?>

<?php echo anchor('hargadagang','Kembali ke Master Harga Dagangan'); ?>