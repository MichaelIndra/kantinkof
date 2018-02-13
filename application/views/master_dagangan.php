<title>Master Dagangan</title>
<?php if ($this->session->flashdata('result')!= null){echo $this->session->flashdata('result').'<hr>'; } ?>
<?php echo anchor('dagang/inputmaster','Input Data Dagang'); ?>
<table>
    <th>Nama Supplier</th>
    <th>Kode Dagang</th>
    <th>Nama Dagang</th>
    <th>Deskripsi Dagang</th>
    <th>Kas Komsel</th>
    <th>Edit</th>

    <?php 
        foreach ($datamaster as $dm) {
            echo '<tr>';
            echo '<td>'.$dm->nama.'</td>';
            echo '<td>'.$dm->iddagang.'</td>';
            echo '<td>'.$dm->namadagang.'</td>';
            echo '<td>'.$dm->deskripsi.'</td>';
            echo '<td>'.$dm->komsel.'</td>';
            echo '<td>'.anchor('dagang/editmaster/'.$dm->iddagang,'Edit').'</td>';
            echo'</tr>';
        }
    ?>

    </table>
<?php echo anchor('welcome','Kembali ke menu utama');?>
