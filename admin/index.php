<?php
extract($_POST);


session_start();
/**
 * Jika Tidak login atau sudah login tapi bukan sebagai admin
 * maka akan dibawa kembali kehalaman login atau menuju halaman yang seharusnya.
*/
    
if ( !isset($_SESSION['user_login']) || 
    ( isset($_SESSION['user_login']) && $_SESSION['user_login'] != 'admin' ) ) {
 
    header('location:./../login.php');
    exit();
}


?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>

        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

        <!--jquery-->
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>

        <link rel="stylesheet" href="dist/css/summernote.css">
        <script src="dist/js/summernote.js"></script>

    </head>

    <body class="hold-transition skin-green sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">ADM</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b><?php echo $_SESSION['nama']?></b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                    </a>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include'menu.php'; ?>
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->

                    <!-- Main content -->
                    <section class="content">
                        <?php 
                if(isset($_GET['page']))
                {
                 switch($_GET['page'])
                {
                    
                    case 'daftar_admin': include'daftar_admin.php'; break;
                    case 'tambah_admin': include'tambah_admin.php'; break;
                    case 'gantipass_admin': include'gantipass_admin.php'; break;
                    case 'rute': include'jarak.php'; break;
                    case 'lokasi': include'lokasi.php'; break;
                    case 'tambah_lokasi': include'tambah_lokasi.php'; break;
                    case 'tambah_rute': include'tambah_rute.php'; break;
                    case 'rute_peta': include'rute_peta.php'; break;
                    case 'edit_lokasi': include'edit_lokasi.php'; break;
                    case 'variabel_algen': include'variabel_algen.php'; break;
                    case 'edit_admin': include'edit_admin.php';$order=3; break;

                    
                }   
                }
                else{
                    echo '<center>
            <img src="../img/Logo_Undip.png" style="width:20%" alt="Logo Undip">
        
                    <h1>Selamat Datang di halaman Admin</h1></center>';
                }
            ?>
                    </section>
                </div>
                <!-- /.content-wrapper -->
                <footer class="main-footer" align="center">
                    <strong>Copyright &copy; 2016<a href="http://undip.ac.id"> Universitas Diponegoro</a>.</strong> All rights reserved.
                </footer>
                <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <!-- Bootstrap 3.3.5 -->
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.konten').summernote({
                    height: 300, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true, // set focus to editable area after initializing summernote
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'hr']],
                        ['view', ['fullscreen', 'codeview']]
                    ],
                    
					onPaste: function (e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        setTimeout(function () {
                            document.execCommand('insertText', false, bufferText);
                        }, 10);
					 }
					
					
					
                });
				
				
            });
        </script>
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script>
            /*$(function () {
                $("#example1").DataTable({
                    "order": [[<?php echo $order; ?>, "desc"]]
                });
            });*/
        </script>
        
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
        
    </body>
    </html>