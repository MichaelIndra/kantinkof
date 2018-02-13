<title>Master Supplier</title>
<?php if ($this->session->flashdata('result')!= null){echo $this->session->flashdata('result').'<hr>'; } ?>
<?php echo anchor('supplier/inputmaster','Input Data Master Supplier'); ?>
<table>
    <th>Nama Supplier</th>
    <th>ID Supplier</th>
    <th>Alamat </th>
    <th>No telp(HP)</th>
    <th>No WA</th>
    <th>Edit</th>

    <?php 
        foreach ($datamaster as $dm) {
            echo '<tr>';
            echo '<td>'.$dm->nama.'</td>';
            echo '<td>'.$dm->idsupp.'</td>';
            echo '<td>'.$dm->alamat.'</td>';
            echo '<td>'.$dm->notelp.'</td>';
            echo '<td>'.$dm->nowa.'</td>';
            echo '<td>'.anchor('supplier/editmaster/'.$dm->idsupp,'Edit').'</td>';
            echo'</tr>';
        }
    ?>

    </table>
<?php echo anchor('welcome','Kembali ke menu utama');?>


