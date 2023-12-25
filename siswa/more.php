<?php 
	
	if($_GET['apa']=="aspirasi"){ ?>

<?php 
	$query = mysqli_query($koneksi,"SELECT * FROM aspirasi INNER JOIN siswa ON aspirasi.nis=siswa.nis WHERE id_aspirasi='".$_GET['id_aspirasi']."'");
	$r=mysqli_fetch_assoc($query);
 ?>
<b>Di Laporakan Pada : <?php echo $r['tgl_aspirasi']; ?></b><br>

<?php 
	if($r['foto']=="kosong"){ ?>
		<img src="../img/noImage.png" width="100">
<?php	}else{ ?>
	<img width="100" src="../img/<?php echo $r['foto']; ?>">
<?php }
 ?>


<p><?php echo $r['isi_laporan']; ?></p>
<p>Status : <?php echo $r['status']; ?></p>

<button><a href="index.php?p=dashboard">Back</a></button>

<?php	}elseif ($_GET['apa']=="tanggapan") { ?>

<?php 
	$query = mysqli_query($koneksi,"SELECT * FROM aspirasi INNER JOIN siswa ON aspirasi.nis=siswa.nis INNER JOIN tanggapan ON aspirasi.id_aspirasi=tanggapan.id_aspirasi INNER JOIN petugas ON tanggapan.id_petugas=petugas.id_petugas WHERE tanggapan.id_aspirasi='".$_GET['id_aspirasi']."'");
	$r=mysqli_fetch_assoc($query);
 ?>
<h2>Petugas <?php echo $r['nama_petugas']; ?></h2>
<b>Ditanggapi pada :<?php echo $r['tgl_tanggapan']; ?></b><br>
<?php 
	if($r['foto']=="kosong"){ ?>
		<img src="../img/noImage.png" width="100">
<?php	}else{ ?>
	<img width="100" src="../img/<?php echo $r['foto']; ?>">
<?php }
 ?>
<p><?php echo $r['isi_laporan']; ?></p>
<p><?php echo $r['tanggapan']; ?></p>
<p>Status : <?php echo $r['status']; ?></p>

<button><a href="index.php?p=dashboard">Back</a></button>

<?php } ?>