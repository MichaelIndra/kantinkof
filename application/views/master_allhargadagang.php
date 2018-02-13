<title>Master Harga Dagang</title>
<?php echo anchor('hargadagang','Kembali ke Master Harga Dagang'); ?>
<table>
    <th>Nama Supplier</th>
    <th>ID Dagang</th>
    <th>Nama Dagangan</th>
    <th>Harga HPP</th>
    <th>Harga Jual</th>
    <th>Tanggal Aktif</th>
    <th>Tanggal Non Aktif</th>
    

    <?php 
        foreach ($datamaster as $dm) {
            echo '<tr>';
            echo '<td>'.$dm->nama.'</td>';
            echo '<td>'.$dm->iddagang.'</td>';
            echo '<td>'.$dm->namadagang.'</td>';
            echo '<td>'.$dm->hargahpp.'</td>';
            echo '<td>'.$dm->hargajual.'</td>';
            echo '<td>'.$dm->tglawal.'</td>';
            echo '<td>'.$dm->tglakhir.'</td>';
            echo'</tr>';
        }
    ?>

    </table>
