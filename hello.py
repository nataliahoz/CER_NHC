#!/usr/bin/python
#"*** coding:"utf*8"**

from flask import Flask, render_template, request
from pymongo import MongoClient
from beebotte import *

import requests
import re

#app = Flask(__name__)
app = Flask(__name__, static_folder='static', static_url_path='/static')



@app.route('/', methods=['GET', 'POST'])
def main():
   global flag
   flag=0
   return render_template('index.html')

@app.route('/loc')
def location(): 
   return '<p> UAH.EPS.EL10 </p>'

@app.route('/datos-form.php', methods=['GET','POST'])
def result():      
   #Leer base de datos y ver que valores estan fuera del intervalo umbral
   umbsup=request.form['umbsup']
   umbinf=request.form['umbinf']
   listsup=[]
   listinf=[]
   [listsup,listinf,lbbtsup,lbbtinf]=busq_resultado(umbsup,umbinf)
   #print(listsup,listinf)
   #Ver cual es el ultimo dato que supero el umbral --> Destacar en negrita
   return render_template('datos-form.php', umbsup=umbsup , umbinf=umbinf, listsup=listsup, listinf=listinf, lbbtsup=lbbtsup, lbbtinf=lbbtinf)
   #return send_from_directory(app.static_folder, request.path[1:],umbsup=umbsup , umbinf=umbinf, listsup=listsup, listinf=listinf, lbbtsup=lbbtsup, lbbtinf=lbbtinf)

def busq_resultado(umbsup,umbinf):
   lsup=[]
   linf=[]
   lbsup=[]
   lbinf=[]
   pos=0
   pos2=0
   strn=' '
   strn2=' '
   
   ##MongoDB
   mongoClient = MongoClient('localhost',27017) #Conexion con MongoDB (port 27017)
   db = mongoClient.Aleatorios        #Definicion de la base de datos
   coll_num = db.Numeros              #Definicion de la coleccion de numeros
   coll_dt = db.Date                  #Definicion de la coleccion de fechas
   coll_tm =db.Time                   #Definicion de la coleccion de horas
   cursor_num=coll_num.find()
   cursor_dt=coll_dt.find()
   cursor_tm=coll_tm.find() 
   ##Beebotte
   bbtClient = BBT('7e43ccf2633ab5fb261d9fcc18d65e13', 'c79e5a07f84c3e605b9f6ca11d8218f89cea7cd157637450b3f6f0bebc9e2924')    #Conexion con Beebotte
   res1 = Resource(bbtClient, 'dev', 'res1')   #Resource Numbers
   res2 = Resource(bbtClient, 'dev', 'res2')   #Resource Fechas
   res3 = Resource(bbtClient, 'dev', 'res3')   #Resource Horas
   record_num=res1.read()
   record_dt=res2.read()
   record_tm=res3.read()
   
   for y in cursor_num:
      strn=str(y['valor'])+'****'+str(cursor_dt[pos]['fecha'])+'****'+str(cursor_tm[pos]['hora'])
      if (float(y['valor']) > float(umbsup)):
         lsup.append(strn)
      elif (float(y['valor']) < float(umbinf)):
         linf.append(strn)  
      else:
         continue
      pos=pos+1
      
   for z in record_num:
      strn2=str(z['data'])+'****'+str(record_dt[pos2]['data'])+'****'+str(record_tm[pos2]['data'])
      if (float(z['data']) > float(umbsup)):
         lbsup.append(strn2)
      elif (float(z['data']) < float(umbinf)):
         lbinf.append(strn2)  
      else:
         continue
      pos2=pos2+1
         
   ##Cierre de conexion MongoDB
   mongoClient.close()
   
   return lsup,linf,lbsup,lbinf

@app.route('/datos-media', methods=['GET'])
def media():
   bbdd=' '
   suma=0
   cont=0
   media=0
   global flag
   if flag % 2 == 0:
      bbdd='MongoDB'
      ##MongoDB
      mongoClient = MongoClient('localhost',27017) #Conexion con MongoDB (port 27017)
      db = mongoClient.Aleatorios        #Definicion de la base de datos
      coll_num = db.Numeros              #Definicion de la coleccion de numeros
      cursor_num=coll_num.find()
      for y in cursor_num:
         suma=float(suma)+float(y['valor'])
         cont=cont+1
      media=float(suma)/cont
      flag=1
   else:
      bbdd='Beebotte'
      ##Beebotte
      bbtClient = BBT('7e43ccf2633ab5fb261d9fcc18d65e13', 'c79e5a07f84c3e605b9f6ca11d8218f89cea7cd157637450b3f6f0bebc9e2924')    #Conexion con Beebotte
      res1 = Resource(bbtClient, 'dev', 'res1')   #Resource Numbers
      record_num=res1.read()
      for z in record_num:
         suma=float(suma)+float(z['data'])
         cont=cont+1
      media=float(suma)/cont
      flag=0
   print (media,bbdd)
   return render_template('datos-media', media=media, bbdd=bbdd)

@app.route('/datos-captura', methods=['POST'])
def captura():
   umbcap=request.form['umbcap']
   rescap=0
   url = 'http://www.numeroalazar.com.ar/'
   regexp=r'([0-9]+.[0-9]+)'
   response = requests.get(url)
   #print(response)
   if response.status_code != 200:
      print('Failed to get data:',response.status_code)
   else:
      str1="numeros_generados"
      str2="</div>"
      shtml=response.text
      pinum=shtml.find(str1)
      pfnum=shtml[pinum:].find(str2)
      number = re.findall(regexp, shtml[pinum:pinum+pfnum])
   for x in number:
      print (float(x))
      if (float(x) > float(umbcap)):
         rescap=float(x)
         timestamp= str(time.strftime("%d/%m/%y"))+' '+str(time.strftime("%H:%M:%S"))
         break
         
   return render_template('datos-captura', umbcap=umbcap, rescap=rescap, timestamp=timestamp)

@app.route('/datos-grafica', methods=['GET'])
def grafica():
   ##MongoDB
   mongoClient = MongoClient('localhost',27017) #Conexion con MongoDB (port 27017)
   db = mongoClient.Aleatorios        #Definicion de la base de datos
   coll_num = db.Numeros              #Definicion de la coleccion de numeros
   
   ##Beebotte
   bbtClient = BBT('7e43ccf2633ab5fb261d9fcc18d65e13', 'c79e5a07f84c3e605b9f6ca11d8218f89cea7cd157637450b3f6f0bebc9e2924')    #Conexion con Beebotte
   res1 = Resource(bbtClient, 'dev', 'res1')   #Resource Numbers
   
   return render_template('datos-grafica')

if __name__ == "__main__":
   app.run(host='0.0.0.0')