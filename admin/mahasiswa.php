<?php 
include('../koneksi/koneksi.php');
if((isset($_GET['aksi']))&&(isset($_GET['data']))){
   if($_GET['aksi']=='hapus'){
      $nim = $_GET['data'];
      //get foto
      $sql_f = "SELECT `foto` FROM `mahasiswa` WHERE `nim`='$nim'";
      $query_f = mysqli_query($koneksi,$sql_f);
      $jumlah_f = mysqli_num_rows($query_f);
    if($jumlah_f>0){
      while($data_f = mysqli_fetch_row($query_f)){
        $foto = $data_f[0];
        //menghapus foto dalam folder foto
        unlink("foto/$foto");
      }
    }
    //hapus hobi
    $sql_dh = "delete from `hobi_mahasiswa` where `nim` = '$nim'";
    mysqli_query($koneksi,$sql_dh);
    //hapus data mahasiswa
    $sql_dm = "delete from `mahasiswa` where `nim` = '$nim'";
    mysqli_query($koneksi,$sql_dm);
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<?php include("includes/head.php") ?> 
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("includes/header.php") ?>

  <?php include("includes/sidebar.php") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3><i class="fas fa-user-tie"></i> Data Mahasiswa</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Data Mahasiswa</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-list-ul"></i> Data Mahasiswa</h3>
                <div class="card-tools">
                  <a href="tambah_mahasiswa.php" class="btn btn-sm btn-info float-right"><i class="fas fa-plus"></i> Tambah Mahasiswa</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="col-md-12">
                  <form method="get" action="mahasiswa.php"> 
                      <div class="row">
                         <div class="col-md-4 bottom-10">
                            <input type="text" class="form-control" 
                            id="kata_kunci" name="katakunci">
                         </div>
                        <div class="col-md-5 bottom-10">
                             <button type="submit" class="btn btn-primary">
                             <i class="fas fa-search"></i>  Search</button>
                       </div>
                      </div><!-- .row -->
                  </form> 

                </div><br>
                <div class="col-sm-12">
                    <div class="alert alert-success" role="alert">Data Berhasil Ditambahkan</div>
                    <div class="alert alert-success" role="alert">Data Berhasil Diubah</div>
                </div>
                <br><br>
                    <div class="col-sm-12">
                       <?php if(!empty($_GET['notif'])){?>
                          <?php if($_GET['notif']=="tambah berhasil"){?>
                            <div class="alert alert-success" role="alert">
                            Data Berhasil Ditambahkan</div>
                          <?php }?>
                        <?php }?>
                    </div>
                    <div class="col-sm-12">
                       <?php if(!empty($_GET['notif'])){?>
                         <?php if($_GET['notif']=="tambahberhasil"){?>
                            <div class="alert alert-success" role="alert">
                            Data Berhasil Ditambahkan</div>
                         <?php } else if($_GET['notif']=="editberhasil"){?>
                           <div class="alert alert-success" role="alert">
                           Data Berhasil Diubah</div>
                         <?php }?>
                      <?php }?>
                    </div>

                <table class="table table-bordered">
                    <thead>                  
                      <tr>
                        <th width="5%">No</th>
                        <th width="25%">NIM</th>
                        <th width="40%">Nama</th>
                        <th width="20%">Jurusan</th>
                        <th width="10%"><center>Aksi</center></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        //menampilkan data mahasiswa 
                       $sql_mhs = "select `m`.`nim`, `m`.`nama`, `j`.`jurusan` 
            from `mahasiswa` `m`
            inner join `jurusan` `j` 
            on `m`.`kode_jurusan` = `j`.`kode_jurusan` "; 
if (isset($_GET["katakunci"])){
    $katakunci_mhs = $_GET["katakunci"];
    $sql_mhs .= " where `nim` LIKE '%$katakunci_mhs%' 
                  OR `nama` LIKE '%$katakunci_mhs%'";
} 
$sql_mhs .= " order by `m`.`nim` ";

                        $query_mhs = mysqli_query($koneksi,$sql_mhs);
                        $no = 1;
                        while($data_mhs = mysqli_fetch_row($query_mhs)){
                          $nim = $data_mhs[0];
                          $nama = $data_mhs[1];
                          $jurusan = $data_mhs[2];
                          ?>
                          <tr>
                              <td><?php echo $no;?></td>
                              <td><?php echo $nim;?></td>
                              <td><?php echo $nama;?></td>
                              <td><?php echo $jurusan;?></td>
                              <td align="center">
                              <a href="edit_mahasiswa.php?data=<?php echo $nim;?>" 
                              class="btn btn-xs btn-info" title="Edit">
                              <i class="fas fa-edit"></i></a>
                              <a href="javascript:if(confirm('Anda yakin ingin menghapus data 
                              <?php echo $nim.' - '.$nama; ?>?'))window.location.href = 'mahasiswa.php?aksi=hapus&data=<?php echo $nim;?>'" 
                              class="btn btn-xs btn-warning">
                              <i class="fas fa-trash" title="Hapus"></i></a><a href="detail_mahasiswa.php?data=<?php echo $nim;?>" 
                              class="btn btn-xs btn-info" title="Detail">
                              <i class="fas fa-eye"></i></a>
                              </td>
                          </tr>
                        <?php $no++; }?>  
                    </tbody>
                  </table>  
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>
            <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("includes/footer.php") ?>

</div>
<!-- ./wrapper -->

<?php include("includes/script.php") ?>
</body>
</html>
