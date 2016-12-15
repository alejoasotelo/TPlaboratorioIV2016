<?php $nocache = '?'.uniqid();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Inmobiliarias</title>

    <!-- Bootstrap -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/global.css<?php echo $nocache;?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        var nocache = '<?php echo $nocache; ?>';
    </script>
</head>
<body ng-app="app">

    <top-menu>
    </top-menu>

    <div id="mainbody" ui-view>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="bower_components/angular/angular.js<?php echo $nocache;?>"></script>
    <script src="bower_components/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="bower_components/dom-to-image/dist/dom-to-image.min.js"></script>
    <script src="bower_components/pdfmake/build/pdfmake.min.js"></script>
    <script src="bower_components/pdfmake/build/vfs_fonts.js"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyBXwcL3-gI_TM05ENcf8kgk38bm24bcziU"></script>
    <script src="bower_components/ngmap/build/scripts/ng-map.js"></script>
    <script src="bower_components/satellizer/dist/satellizer.min.js"></script>
    <script src="bower_components/angular-file-upload/dist/angular-file-upload.min.js" type="text/javascript" ></script>
    <script src="bower_components/angular-sanitize/angular-sanitize.min.js" type="text/javascript" ></script>
    <script src="bower_components/table-export/tableExport.js" type="text/javascript" ></script>
    <script src="bower_components/table-export/jquery.base64.js" type="text/javascript" ></script>
    <script src="bower_components/table-export/html2canvas.js" type="text/javascript" ></script>
    <script type="text/javascript" src="bower_components/table-export/jspdf/libs/sprintf.js"></script>
    <script type="text/javascript" src="bower_components/table-export/jspdf/libs/base64.js"></script>
    <script type="text/javascript" src="bower_components/table-export/jspdf/jspdf.js"></script>

    <script src="app.js<?php echo $nocache;?>"></script>
    
    <script src="scripts/modules/auth/auth.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/auth/login.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/auth/register.js<?php echo $nocache;?>"></script>
    
    <script src="scripts/modules/usuarios/usuarios.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/usuarios/listar.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/usuarios/nuevo.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/usuarios/modificar.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/usuarios/local.js<?php echo $nocache;?>"></script>
    
    <script src="scripts/modules/locales/locales.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/locales/listar.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/locales/nuevo.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/locales/modificar.js<?php echo $nocache;?>"></script>

    <script src="scripts/modules/ofertas/ofertas.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/ofertas/listar.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/ofertas/nuevo.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/ofertas/modificar.js<?php echo $nocache;?>"></script>

    <script src="scripts/modules/propiedades/propiedades.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/propiedades/listar.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/propiedades/nuevo.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/propiedades/modificar.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/propiedades/ver.js<?php echo $nocache;?>"></script>

    <script src="scripts/modules/ventas_alquileres/ventas_alquileres.js<?php echo $nocache;?>"></script>
    <script src="scripts/modules/ventas_alquileres/listar.js<?php echo $nocache;?>"></script>

    <script src="scripts/services/empleados.js<?php echo $nocache;?>"></script>
    <script src="scripts/services/encargados.js<?php echo $nocache;?>"></script>
    <script src="scripts/services/locales.js<?php echo $nocache;?>"></script>
    <script src="scripts/services/ofertas.js<?php echo $nocache;?>"></script>
    <script src="scripts/services/propiedades.js<?php echo $nocache;?>"></script>
    <script src="scripts/services/usuarios.js<?php echo $nocache;?>"></script>
    <script src="scripts/services/permisos.js<?php echo $nocache;?>"></script>
    <script src="scripts/services/ventas_alquileres.js<?php echo $nocache;?>"></script>

    <script src="scripts/directives/top-menu.js<?php echo $nocache;?>"></script>
    <script src="scripts/directives/tools-menu.js<?php echo $nocache;?>"></script>
    <script src="scripts/directives/ng-thumb.js<?php echo $nocache;?>"></script>
    <script src="scripts/directives/ng-usuario.js<?php echo $nocache;?>"></script>

    <script src="scripts/factory/api.js<?php echo $nocache;?>"></script>
</body>
</html>