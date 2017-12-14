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
      position: relative;
      bottom: 0;
      width: 100%;
   }
</style>
 
<head>
    <title>Random Numbers App</title>
    <meta charset="utf-8">
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <script Language="JavaScript">
      function genera_tabla(arg1,arg2,arg3,arg4) {
      // Obtener la referencia del elemento body
      var body = document.getElementsByTagName("body")[0];
      // Crea un elemento <table> y un elemento <tbody>
      var tabla   = document.createElement("table");
      var tblBody = document.createElement("tbody");
      // Crea las celdas
      textoini=["Superiores en MongoDB","Inferiores en MongoDB","Superiores en Beebotte","Inferiores en Beebotte"]
      maxlen=Math.max(arg1.length,arg2.length,arg3.length,arg4.length)
      for (var i = 0; i<maxlen+1 ; i++) {
       // Crea las hileras de la tabla
       var hilera = document.createElement("tr");
       for (var j = 0; j < 4; j++) {
         if (j==0)
            arg=arg1
         else if (j==1)
            arg=arg2
         else if (j==2)
            arg=arg3
         else if (j==3)
            arg=arg4
         
         // Crea un elemento <td> y un nodo de texto, haz que el nodo de
         // texto sea el contenido de <td>, ubica el elemento <td> al final
         // de la hilera de la tabla
         var celda = document.createElement("td");
         if (i==0) 
            var textoCelda = document.createTextNode(textoini[j]);
         else if (arg[i-1] != null)
            var textoCelda = document.createTextNode(arg[i-1]);
         else if (arg[i-1] == null)
            var textoCelda = document.createTextNode(" ");
         
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
      tabla.setAttribute("align", "center");
      alert("Resultados estan cargados");
      }
            // This is called with the results from from FB.getLoginStatus().
      function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
          // Logged into your app and Facebook.
          console.log('Ya conectado');     
          document.getElementById('btn-log-out').style.display = 'block';
          testAPI();
        } else {
         console.log('A conectarse!!!');
          // The person is not logged into your app or we are unable to tell.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
          document.getElementById('btn-log-out').style.display = 'none';
          
        }
      }
    
      // This function is called when someone finishes with the Login
      // Button.  See the onlogin handler attached to it in the sample
      // code below.
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }
    
      window.fbAsyncInit = function() {
      FB.init({
        appId      : '886609554837626',
        cookie     : true,  // enable cookies to allow the server to access 
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.8' // use graph api version 2.8
      });
    
      // Now that we've initialized the JavaScript SDK, we call 
      // FB.getLoginStatus().  This function gets the state of the
      // person visiting this page and can return one of three states to
      // the callback you provide.  They can be:
      //
      // 1. Logged into your app ('connected')
      // 2. Logged into Facebook, but not your app ('not_authorized')
      // 3. Not logged into Facebook and can't tell if they are logged into
      //    your app or not.
      //
      // These three cases are handled in the callback function.
    
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
      FB.AppEvents.logPageView(); 
    
      };
    
      // Load the SDK asynchronously
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    
      // Here we run a very simple test of the Graph API after login is
      // successful.  See statusChangeCallback() for when this call is made.
      function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
          console.log('Successful login for: ' + response.name);
          document.getElementById('status').innerHTML =
            'Aqui estan los datos solicitados, ' + response.name + '!';
        });
      
      }
      function mysignout(){
         FB.logout(function(response)
         {
             console.log('Successful logout for: ' + response.name); 
             document.getElementById('status').innerHTML ='Logout realizado. \n Por favor haga Log in de nuevo para disfrutar de las herramienta de la web. '
            document.getElementById('btn-log-out').style.display = 'none';
            window.location.href = "/";
         });
      }
   </script>
</head>


<body onload="checkLoginState();" style=background-color:#FFFFCC; margin-left:2cm>
 
    <div class="container">
        <div class="header">
            <nav>
                <ul class="nav nav-pills pull-right">
                    <li role="presentation" class="active"><a href="/">  Home  </a>
                    </li>
                    <li id="btn-log-out">
                      <a onclick="mysignout();" href="#">Log out</a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <div class="principal">
            <h3 class="text-muted">Random Numbers App</h3>
            </p>
        </div>
        <div id="status">
        </div>
        <center>
           <div style="text-align:center;padding:1em 0;"> 
               <h4>
                  <a style="text-decoration:none;" href="https://www.zeitverschiebung.net/es/city/3117735"><span style="color:gray;">Hora actual en</span><br />Madrid, Spain</a>
               </h4> 
               <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=small&timezone=Europe%2FMadrid" width="100%" height="90" frameborder="0" seamless></iframe>
           </div>
           <h3 class="text-muted">Resultados</h3>
           <p><b>  Umbral Superior:</b> {{umbsup}}</p>
           <p><b>  Umbral Inferior:</b> {{umbinf}}</p>
           <p> ----------------------------- </p>
           <script type="text/javascript" margin-left:20px;>
               genera_tabla({{listsup}},{{listinf}},{{lbbtsup}},{{lbbtinf}});
           </script>
           <footer class="footer">
            <p>&copy; Natalia de la Hoz Carracedo - Computacion en red - UAH 2017</p>
           </footer>
        </center>
    </div>
</body>

 
</html>