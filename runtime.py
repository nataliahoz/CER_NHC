from flask import Flask
from pymongo import MongoClient
from beebotte import *

import requests
import re
import pymongo
import time

if __name__ == "__main__":
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

  ##MongoDB
  mongoClient = MongoClient('localhost',27017) #Conexion con MongoDB (port 27017)
  db = mongoClient.Aleatorios    #Base de datos Aleatorios
  coll_num = db.Numeros          #Definicion de la coleccion Numeros
  coll_dt = db.Date              #Definicion de la coleccion Date
  coll_tm =db.Time               #Definicion de la coleccion Time
  
  ##Beebotte
  bbtClient = BBT('7e43ccf2633ab5fb261d9fcc18d65e13', 'c79e5a07f84c3e605b9f6ca11d8218f89cea7cd157637450b3f6f0bebc9e2924')    #Conexion con Beebotte
  res1 = Resource(bbtClient, 'dev', 'res1')   #Resource Numbers
  res2 = Resource(bbtClient, 'dev', 'res2')   #Resource Fechas
  res3 = Resource(bbtClient, 'dev', 'res3')   #Resource Horas
  
  ###Escritura de datos
  for x in number:
    ##Gestion de MongoDB 
    
    numero = {'valor': str(x)}                        #Documento numero
    fecha = {'fecha': str(time.strftime("%d/%m/%y"))} #Documento fecha
    hora = {'hora': str(time.strftime("%H:%M:%S"))}   #Documento hora
    coll_num.insert(numero)                           #Inserta documento numero en coleccion Numeros
    coll_dt.insert(fecha)                             #Inserta documento fecha en coleccion Date
    coll_tm.insert(hora)                              #Inserta documento hora en coleccion Time
    
    ##Gestion de Beebote 
    res1.write(float(x))                          # Escribir en el Resource Numbers
    res2.write(str(time.strftime("%d/%m/%y")))  # Escribir en el Resource Fechas
    res3.write(str(time.strftime("%H:%M:%S")))  # Escribir en el Resource Horas
    break

  ##Cierre de conexion MongoDB
  mongoClient.close()

