<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
    <title>Sistema Contábil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Novus Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- font CSS -->
    <!-- font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!-- js-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <!--webfonts-->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!--//webfonts-->
    <!--animate-->
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <!--//end-animate-->
    <!-- chart -->
    <script src="js/Chart.js"></script>
    <!-- //chart -->
    <!--Calender-->
    <link rel="stylesheet" href="css/clndr.css" type="text/css" />
    <script src="js/underscore-min.js" type="text/javascript"></script>
    <script src= "js/moment-2.2.1.js" type="text/javascript"></script>
    <script src="js/clndr.js" type="text/javascript"></script>
    <script src="js/site.js" type="text/javascript"></script>
    <!--End Calender-->
    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
</head>
<?php

include "calculo_indices.php";

$bdServidor = '25.71.230.218';
$bdUsuario = 'siscont';
$bdSenha = 'contabilidade';
$bdBanco = 'contabilidade';

$conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

if(mysqli_connect_errno($conexao)){
    echo "Erro na conexão!";
    die();
}

$deleterecords1 = "TRUNCATE TABLE BP"; //Esvaziar a tabela
$deleterecords2 = "TRUNCATE TABLE DRE"; //Esvaziar a tabela
$deleterecords3 = "TRUNCATE TABLE DFC"; //Esvaziar a tabela
mysqli_query($conexao, $deleterecords1);
mysqli_query($conexao, $deleterecords2);
mysqli_query($conexao, $deleterecords3);

//Transferir o arquivo
if (isset($_POST['envia_dado'])) {

//Importar o arquivo transferido para o banco de dados
    $handle = fopen($_FILES['filename']['tmp_name'], "r");

    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $import_BP="INSERT into bp(conta_bp, ano1_bp, ano2_bp) values('$data[0]','$data[1]','$data[2]')";
        $import_DRE="INSERT into dre(conta_dre, ano1_dre, ano2_dre) values('$data[3]','$data[4]','$data[5]')";
        $import_DFC="INSERT into dfc(conta_dfc, ano1_dfc, ano2_dfc) values('$data[6]','$data[7]','$data[8]')";

        mysqli_query($conexao, $import_BP) or die(mysqli_error());
        mysqli_query($conexao, $import_DRE) or die(mysqli_error());
        mysqli_query($conexao, $import_DFC) or die(mysqli_error());
    }

    fclose($handle);

    $resultado = calcula_indices($conexao);


}
?>
<body class="cbp-spmenu-push">
<div class="main-content">
    <!--left-fixed -navigation-->
    <div class=" sidebar" role="navigation">
        <div class="navbar-collapse">
            <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.html" ><i class="fa fa-home nav_icon"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="indices.html" class="active"><i class="fa fa-table nav_icon"></i>Calcular Índices</a>
                    </li>
                    <li>
                        <a href="graficos.html"><i class="fa fa-bar-chart nav_icon"></i>Gráficos</a>
                    </li>
                    <li>
                        <a href="sobre.html" ><i class="fa fa-file-text-o nav_icon"></i>Sobre</a>
                    </li>
                </ul>
                <div class="clearfix"> </div>
                <!-- //sidebar-collapse -->
            </nav>
        </div>
    </div>
    <!--left-fixed -navigation-->
    <!-- header-starts -->
    <div class="sticky-header header-section ">
        <div class="header-left">
            <!--toggle button start-->
            <button id="showLeftPush"><i class="fa fa-bars"></i></button>
            <!--toggle button end-->
            <!--logo -->
            <div class="logo">
                <a href="index.html">
                    <h1>Contabilidade</h1>
                    <span>Índices</span>
                </a>
            </div>
            <!--//logo-->
            <!--search-box-->
            <!--<div class="search-box">
                <form class="input">
                    <input class="sb-search-input input__field--madoka" placeholder="Search..." type="search" id="input-31" />
                    <label class="input__label" for="input-31">
                        <svg class="graphic" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
                            <path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
                        </svg>
                    </label>
                </form>
            </div>//end-search-box-->
            <div class="clearfix"> </div>
        </div>
        <div class="header-right">
            <!--<div class="profile_details_left"><!--notifications of menu start
                <ul class="nofitications-dropdown">
                    <li class="dropdown head-dpdn">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">3</span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="notification_header">
                                    <h3>You have 3 new messages</h3>
                                </div>
                            </li>
                            <li><a href="#">
                                <div class="user_img"><img src="images/1.png" alt=""></div>
                                <div class="notification_desc">
                                    <p>Lorem ipsum dolor amet</p>
                                    <p><span>1 hour ago</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </a></li>
                            <li class="odd"><a href="#">
                                <div class="user_img"><img src="images/2.png" alt=""></div>
                                <div class="notification_desc">
                                    <p>Lorem ipsum dolor amet </p>
                                    <p><span>1 hour ago</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </a></li>
                            <li><a href="#">
                                <div class="user_img"><img src="images/3.png" alt=""></div>
                                <div class="notification_desc">
                                    <p>Lorem ipsum dolor amet </p>
                                    <p><span>1 hour ago</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </a></li>
                            <li>
                                <div class="notification_bottom">
                                    <a href="#">See all messages</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown head-dpdn">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">3</span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="notification_header">
                                    <h3>You have 3 new notification</h3>
                                </div>
                            </li>
                            <li><a href="#">
                                <div class="user_img"><img src="images/2.png" alt=""></div>
                                <div class="notification_desc">
                                    <p>Lorem ipsum dolor amet</p>
                                    <p><span>1 hour ago</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </a></li>
                            <li class="odd"><a href="#">
                                <div class="user_img"><img src="images/1.png" alt=""></div>
                                <div class="notification_desc">
                                    <p>Lorem ipsum dolor amet </p>
                                    <p><span>1 hour ago</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </a></li>
                            <li><a href="#">
                                <div class="user_img"><img src="images/3.png" alt=""></div>
                                <div class="notification_desc">
                                    <p>Lorem ipsum dolor amet </p>
                                    <p><span>1 hour ago</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </a></li>
                            <li>
                                <div class="notification_bottom">
                                    <a href="#">See all notifications</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown head-dpdn">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i><span class="badge blue1">15</span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="notification_header">
                                    <h3>You have 8 pending task</h3>
                                </div>
                            </li>
                            <li><a href="#">
                                <div class="task-info">
                                    <span class="task-desc">Database update</span><span class="percentage">40%</span>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="progress progress-striped active">
                                    <div class="bar yellow" style="width:40%;"></div>
                                </div>
                            </a></li>
                            <li><a href="#">
                                <div class="task-info">
                                    <span class="task-desc">Dashboard done</span><span class="percentage">90%</span>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="progress progress-striped active">
                                    <div class="bar green" style="width:90%;"></div>
                                </div>
                            </a></li>
                            <li><a href="#">
                                <div class="task-info">
                                    <span class="task-desc">Mobile App</span><span class="percentage">33%</span>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="progress progress-striped active">
                                    <div class="bar red" style="width: 33%;"></div>
                                </div>
                            </a></li>
                            <li><a href="#">
                                <div class="task-info">
                                    <span class="task-desc">Issues fixed</span><span class="percentage">80%</span>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="progress progress-striped active">
                                    <div class="bar  blue" style="width: 80%;"></div>
                                </div>
                            </a></li>
                            <li>
                                <div class="notification_bottom">
                                    <a href="#">See all pending tasks</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"> </div>
            </div>-->
            <!--notification menu end -->
            <!--<div class="profile_details">
                <ul>
                    <li class="dropdown profile_details_drop">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div class="profile_img">
                                <span class="prfil-img"><img src="images/a.png" alt=""> </span>
                                <div class="user-name">
                                    <p>Wikolia</p>
                                    <span>Administrator</span>
                                </div>
                                <i class="fa fa-angle-down lnr"></i>
                                <i class="fa fa-angle-up lnr"></i>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu drp-mnu">
                            <li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li>
                            <li> <a href="#"><i class="fa fa-user"></i> Profile</a> </li>
                            <li> <a href="#"><i class="fa fa-sign-out"></i> Logout</a> </li>
                        </ul>
                    </li>
                </ul>
            </div> -->
            <div class="clearfix"> </div>
        </div>
        <div class="clearfix"> </div>
    </div>
    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
        <div class="main-page">
            <div class="forms">
                <h3 class="title1">Índices</h3>
                <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                    <div class="form-title">
                        <h4>Insira aqui o seu arquivo .csv</h4>
                    </div>
                    <div class="form-body">
                        <form enctype='multipart/form-data' action='#' method='post'>
                            <div class="form-group"> <label for="exampleInputFile">Arquivo: </label> <input type="file" name='filename' > <p class="help-block">Para mais informações sobre arquivos .csv visite a seção "Sobre"</p> </div> <button name="envia_dado" type="submit" class="btn btn-default">Enviar</button> </form>
                    </div>
                </div>
            </div>
            <div class="tables">

                <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                    <h4>Índices calculados:</h4>
                    <table class="table table-hover"> <thead> <tr> <th>Quocientes</th> <th>Índice</th> <th>Análise</th> </tr> </thead> <tbody> <tr>
                            <th scope="row">Cobertura de juros com caixa = FCO antes de juros e impostos / juros</th> <td><?php if(isset($resultado)) echo $resultado[0]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[1]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">Cobertura de dividendos com caixa = FCO / dividendos totais</th> <td><?php if(isset($resultado)) echo $resultado[2]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">Qualidade das vendas = caixa das vendas / vendas</th> <td><?php if(isset($resultado)) echo $resultado[3]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">Qualidade do resultado =  FCO / resultado operacional</th> <td><?php if(isset($resultado)) echo $resultado[4]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">Aquisições de capital = (FCO - dividendo total) / caixa pago por investimento de capital</th> <td><?php if(isset($resultado)) echo $resultado[5]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">Investimento/financiamento = fluxo de caixa líquido para investimentos / fluxo de caixa líquido de financiamentos</th> <td><?php if(isset($resultado)) echo $resultado[6]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">Retorno do caixa sobre os ativos =  FCO antes juros e impostos / ativos totais</th> <td><?php if(isset($resultado)) echo $resultado[7]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">Retorno sobre passivo e patrimônio líquido = FCO / (patrimônio líquido + exigível a longo prazo)</th> <td><?php if(isset($resultado)) echo $resultado[8]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[9]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[10]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[11]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[12]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[13]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[14]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[15]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[16]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[17]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[18]?></td> <td>AAAAAAAA</td> </tr> <tr>
                            <th scope="row">//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível</th> <td><?php if(isset($resultado)) echo $resultado[19]?></td> <td>AAAAAAAA</td> </tr> <tr>

                            <th scope="row">eeeeeeeeeeeeee</th> <td>rrrrrrrrrrrrrrrr</td> <td>ooooooooooooooooooooo</td> </tr> </tbody> </table>

                </div>
            </div>
        </div>
    </div>
    <!--footer-->
    <div class="footer">
        <p>&copy; 2016 Novus Admin Panel. All Rights Reserved | Design by <a href="https://w3layouts.com/" target="_blank">w3layouts</a></p>
    </div>
    <!--//footer-->
</div>
<!-- Classie -->
<script src="js/classie.js"></script>
<script>
    var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
        showLeftPush = document.getElementById( 'showLeftPush' ),
        body = document.body;

    showLeftPush.onclick = function() {
        classie.toggle( this, 'active' );
        classie.toggle( body, 'cbp-spmenu-push-toright' );
        classie.toggle( menuLeft, 'cbp-spmenu-open' );
        disableOther( 'showLeftPush' );
    };

    function disableOther( button ) {
        if( button !== 'showLeftPush' ) {
            classie.toggle( showLeftPush, 'disabled' );
        }
    }
</script>
<!--scrolling js-->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!--//scrolling js-->
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js"> </script>
</body>
</html>