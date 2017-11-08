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
    <script Language="JavaScript">
      function genera_tabla() {
      // Obtener la referencia del elemento body
      var body = document.getElementsByTagName("body")[0];
      // Crea un elemento <table> y un elemento <tbody>
      var tabla   = document.createElement("table");
      var tblBody = document.createElement("tbody");
      // Crea las celdas
      for (var i = 0; i < 2; i++) {
       // Crea las hileras de la tabla
       var hilera = document.createElement("tr");
       for (var j = 0; j < 2; j++) {
         // Crea un elemento <td> y un nodo de texto, haz que el nodo de
         // texto sea el contenido de <td>, ubica el elemento <td> al final
         // de la hilera de la tabla
         var celda = document.createElement("td");
         var textoCelda = document.createTextNode("celda en la hilera "+i+", columna "+j);
         celda.appendChild(textoCelda);
         hilera.appendChild(celda);
       }
       // agrega la hilera al final de la tabla (al final del elemento tblbody)
       tblBody.appendChild(hilera);
      }
      // posiciona el <tbody> debajo del elemento <table>
      tabla.appendChild(tblBody);
      // appends <table> into <body>
      body.appendChild(tabla);
      // modifica el atributo "border" de la tabla y lo fija a "2";
      tabla.setAttribute("border", "2");
      }
   </script>
   <script Language="JavaScript">
   
      <!-- Helpers for JSI page...-->
      // Navigation - Start
      function goback(){
      alert("Good Bye!");
      history.go(-1);
      }
      function gettheDate() {
      Todays = new Date();
      TheDate = "" + (Todays.getMonth()+ 1) +" / "+ Todays.getDate() + " / " + (Todays.getYear() + 1900) 
      document.clock.thedate.value = TheDate;
      }
      // Navigation - Stop
      // Netscapes Clock - Start
      // this code was taken from Netscapes JavaScript documentation at
      // www.netscape.com on Jan.25.96
      var timerID = null;
      var timerRunning = false;
      function stopclock (){
      if(timerRunning)
      clearTimeout(timerID);
      timerRunning = false;
      }
      function startclock () {
      // Make sure the clock is stopped
      stopclock();
      gettheDate()
      showtime();
      }
      function showtime () {
      var now = new Date();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var seconds = now.getSeconds()
      var timeValue = "" + ((hours >12) ? hours -12 :hours)
      timeValue += ((minutes < 10) ? ":0" : ":") + minutes
      timeValue += ((seconds < 10) ? ":0" : ":") + seconds
      timeValue += (hours >= 12) ? " P.M." : " A.M."
      document.clock.face.value = timeValue;
      // you could replace the above with this
      // and have a clock on the status bar:
      // window.status = timeValue;
      timerID = setTimeout("showtime()",1000);
      timerRunning = true;
      }
      // Netscapes Clock - Stop
      // end Helpers -->
   
   </script>

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
        <table border>
         <tr>
            <td><form name="clock" onSubmit="0"></td>
         </tr>
         <tr>
            <td colspan=2>Hoy es: <input type="text" name="thedate" size=12 value=""></td>
            <td colspan=2>La hora es: <input type="text" name="face" size=12 value=""></td></form>
         </tr>
         </table>
        <footer class="footer">
            <p>&copy; Natalia de la Hoz Carracedo - Computacion en red - UAH 2017</p>
        </footer>
 
    </div>
</body>
 
</html>