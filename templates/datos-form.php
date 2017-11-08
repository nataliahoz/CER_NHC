<!DOCTYPE html>
<html lang="es">
   
<style>
   form {
     width: 450px;
   }
   div {
     margin-bottom: 20px;
   }
   label {
     display: inline-block;
     width: 240px;
     text-align: right;
     padding-right: 10px;
   }
   button {
     float: right;
   } 
   input {
     float: right;
     width: 200px;
   }
   footer {
      position: absolute;
      bottom: 0;
      width: 100%;
   }
</style>
 
<head>
    <title>Random Numbers App</title>
    <meta charset="utf-8">
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">

</head>
 
<body style=background-color:#FFFFCC;>
 
    <div class="container">
        <div class="header">
            <nav>
                <ul class="nav nav-pills pull-right">
                    <li role="presentation" class="active"><a href="/">Home</a>
                    </li>
                    <li role="presentation"><a href="#">  Sign In  </a>
                    </li>
                    <li role="presentation"><a href="showSignUp">  Sign Up  </a>
                    </li>
                </ul>
            </nav>
            <h3 class="text-muted">Resultados</h3>
        </div>
 
        <p>Umbral Superior: {{umbsup}}</p>
        <p>Umbral Inferior: {{umbinf}}</p>
        <h2 class="text-muted">Resultados Superiores:</h2> 
            <!--<li>{{listsup}}</li>-->
            {{listsup}}
        <h2 class="text-muted">Resultados Inferiores:</h2>
            <table width="100%" border="1">
               <? $arrays={{listinf}}; ?>
               <? foreach($arrays as $array):?>
                     <tr><?php echo $arrays ?></tr>
               <? endforeach;?>
            </table>
            <!--<li >{{listinf}}</li>-->
            {{listinf}}
        <h2 class="text-muted">Resultados Superiores (Beebotte):</h2> 
            <!--<li>{{listsup}}</li>-->
            {{lbbtsup}}
        <h2 class="text-muted">Resultados Inferiores (Beebotte):</h2>
            <!--<table width="100%" border="1">
               <?php $arrays={{listinf}}; ?>
               <?php foreach($arrays as $array):?>
                     <li><?php echo $arrays ?></li>
               <?php endforeach;?>
            </table>-->
            <!--<li >{{listinf}}</li>-->
            {{lbbtinf}}
        <footer class="footer">
            <p>&copy; Natalia de la Hoz Carracedo - Computacion en red - UAH 2017</p>
        </footer>
 
    </div>
</body>
 
</html>