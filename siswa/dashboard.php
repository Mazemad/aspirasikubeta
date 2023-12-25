<table class="responsive-table" border="2" style="width: 100%;">
	<tr>
		<td><h4 class="orange-text hide-on-med-and-down">Tulis Aspirasi</h4></td>
		<td><h4 class="orange-text hide-on-med-and-down">Daftar Aspirasi</h4></td>
	</tr>
	<tr>
		<td style="padding: 20px;">
			<form method="POST" enctype="multipart/form-data">
				<textarea class="materialize-textarea" name="laporan" placeholder="Tulis Aspirasi"></textarea><br><br>
				<label>Gambar</label>
				<input type="file" name="foto"><br><br>
				<input type="submit" name="kirim" value="Kirim" class="btn">
			</form>
		</td>

		<td>

			<table border="3" class="responsive-table striped highlight">
				<tr>
					<td>No</td>
					<td>NIS</td>
					<td>Nama</td>
					<td>Tanggal Masuk</td>
					<td>Status</td>
					<td>Opsi</td>
				</tr>
	
				<?php 
		$no=1;
		$query = mysqli_query($koneksi,"SELECT * FROM aspirasi INNER JOIN siswa ON aspirasi.nis=siswa.nis ORDER BY aspirasi.id_aspirasi DESC");
		while ($r=mysqli_fetch_assoc($query)) { ?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $r['nis']; ?></td>
			<td><?php echo $r['nama']; ?></td>
			<td><?php echo $r['tgl_aspirasi']; ?></td>
			<td><?php echo $r['status']; ?></td>
			<td><a class="btn modal-trigger blue" href="#more?id_aspirasi=<?php echo $r['id_aspirasi'] ?>">More</a>  <a class="btn red" onclick="return confirm('Anda Yakin Ingin Menghapus Y/N')" href="index.php?p=aspirasi_hapus&id_aspirasi=<?php echo $r['id_aspirasi'] ?>">Hapus</a></td>

<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->
        <!-- Modal Structure -->
        <div id="more?id_aspirasi=<?php echo $r['id_aspirasi'] ?>" class="modal">
          <div class="modal-content">
            <h4 class="orange-text">Detail</h4>
            <div class="col s12 m6">
				<p>NIS : <?php echo $r['nis']; ?></p>
            	<p>Dari : <?php echo $r['nama']; ?></p>
				<p>Tanggal Masuk : <?php echo $r['tgl_aspirasi']; ?></p>
				<?php 
					if($r['foto']=="kosong"){ ?>
						<img src="../img/noImage.png" width="100">
				<?php	}else{ ?>
					<img width="100" src="../img/<?php echo $r['foto']; ?>">
				<?php }
				 ?>
				<br><b>Pesan</b>
				<p><?php echo $r['isi_laporan']; ?></p>
				<p>Status : <?php echo $r['status']; ?></p>
            </div>
<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->

		</tr>
            <?php  }
             ?>

          </tbody>
        </table>        
	<?php 
		
		if(isset($_POST['kirim'])){
			$nis = $_SESSION['data']['nis'];
			$tgl = date('Y-m-d');


			$foto = $_FILES['foto']['name'];
			$source = $_FILES['foto']['tmp_name'];
			$folder = './../img/';
			$listeks = array('jpg','png','jpeg');
			$pecah = explode('.', $foto);
			$eks = $pecah['1'];
			$size = $_FILES['foto']['size'];
			$nama = date('dmYis').$foto;

			if($foto !=""){
				if(in_array($eks, $listeks)){
					if($size<=100000){
						move_uploaded_file($source, $folder.$nama);
						$query = mysqli_query($koneksi,"INSERT INTO aspirasi VALUES (NULL,'$tgl','$nis','".$_POST['laporan']."','$nama','proses')");

						if($query){
							echo "<script>alert('aspirasi Akan Segera di Proses')</script>";
							echo "<script>location='index.php';</script>";
						}

					}
					else{
						echo "<script>alert('Akuran Gambar Tidak Lebih Dari 100KB')</script>";
					}
				}
				else{
					echo "<script>alert('Format File Tidak Di Dukung')</script>";
				}
			}
			else{
				$query = mysqli_query($koneksi,"INSERT INTO aspirasi VALUES (NULL,'$tgl','$nis','".$_POST['laporan']."','noImage.png','proses')");
				if($query){
					echo "<script>alert('Aspirasi Akan Segera Ditanggapi')</script>";
					echo "<script>location='index.php';</script>";
				}
			}

		}

	?>