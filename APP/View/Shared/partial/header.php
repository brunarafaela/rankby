<!doctype html>
<html lang="pt-br">
    
<head>
	<meta charset="utf-8">
	<!-- TODO: keywords -->
	<meta name="keywords" content="" />
	<?php echo call('Helper/OpenGraph')->generate($pData['ogp']);?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" type="text/css">
    
    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
 
    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/css/bg-gradient-rkng.css" rel="stylesheet">
	<!-- arquivos de css -->
	<link rel="shortcut icon" href="" type="image/x-icon" />
	<?php getCs(); ?>
	
  <!-- Bootstrap core JavaScript-->
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <?php getJs(); ?>

</head>
    
<body id="page-top">
    
  <!-- Page Wrapper -->
  <div id="wrapper">