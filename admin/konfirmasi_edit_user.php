<?php 
	session_start();
	include('../koneksi/koneksi.php');
	if(isset($_SESSION['id_admin'])){
		$id_admin = $_SESSION['id_admin'];
		$nama = $_POST['nama'];
		$email = $_POST['email'];	 
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$level = $_POST['level'];
		
		$_SESSION['nama']=$nama;
		$_SESSION['email']=$email;
		$_SESSION['username']=$username;
		$_SESSION['password']=$password;
		$_SESSION['level']=$level;
		if(empty($nama)){
			header("Location:edit_user.php?data=".$id_admin."&notif=editkosong&jenis=nama");
		}else if(empty($email)){
			header("Location:edit_user.php?data=".$id_admin."&notif=editkosong&jenis=email");
		}else if(empty($username)){
			header("Location:edit_user.php?data=".$id_admin."&notif=editkosong&jenis=username");
		}else if(empty($password)){
			header("Location:edit_user.php?data=".$id_admin."&notif=editkosong&jenis=password");
		}else if(empty($level)){
			header("Location:edit_user.php?data=".$id_admin."&notif=editkosong&jenis=level");
		}else{
			$sql = "update `admin` set `nama`='$nama',`email`='$email', `username`='$username',`password`='$password',`level`='$level' where `id_admin` = '$id_admin'";
			mysqli_query($koneksi,$sql);
			
			unset($_SESSION['nama']);
			unset($_SESSION['email']);
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			unset($_SESSION['level']);
			header("Location:user.php?notif=editberhasil");
		}
	}
?>