# Este archivo sólo se llamará desde index.php para registrar en la base de datos el tipo y el número de placas de la que se disponen

import numpy as np
import mysql.connector
import json
from datetime import datetime, date
import sys
import math

eficiencia = 22.24
area = 2.16
edificio = 'citic'

eficiencia = eficiencia/ 100

# Nos conectamos a la base de datos
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="consumo_ugr"
)
cursor = conexion.cursor()

"""
# Leer el archivo txt con los datos meteorológicos
with open("data/aemet.txt", "r") as file:
    contenido = file.read()

# Lo pasamos a formato JSON
data = json.loads(contenido)

for registro in data:
    fecha = registro["fecha"]
    sol = registro["sol"].replace(',','.')
    tmax = registro["tmax"].replace(',','.')
    tmin = registro["tmin"].replace(',','.')
    consulta = "INSERT INTO aemet (Fecha, Horas_sol, Tmax, Tmin) VALUES (%s, %s, %s, %s)"
    valores = (fecha, sol, tmax, tmin)
    cursor.execute(consulta,valores)

conexion.commit()
cursor.close()
# Cerrar la conexión a la base de datos
conexion.close()"""

# -------------------------------------------------------- FUNCIONES ----------------------------------------------------- #

# Función para calcular la radiación solar diaria extreaterrestre
def radiacion_solar_diaria(s0, latitud, declinacion, horas_soleadas):
    radianes_latitud = np.radians(latitud)
    radiacion_solar_diaria = s0 * 3600 * (np.sin(np.radians(90 - radianes_latitud + declinacion))) * (2 * horas_soleadas / np.pi)
    return radiacion_solar_diaria

# Funcion para calcular el parámetro solar S0
def parametro_solar(dm, d):
    return 1367 * (dm/d)**2; # W/m^2

# Funcion para calcular la distancia de la tierra al Sol en una fecha concreta
# D es el número de días desde el 22 de marzo
def distancia(fecha):
    f_inicial = date(fecha.year, 3, 22)
    D = (fecha - f_inicial).days
    #if D < 0
    return (1.496*10**11) * (1-0.017 * np.sin(0.9856 * D)) # cm

# Función para calcular la declinación solar
def declinacion_solar(dia_del_anio):
    return 23.45 * np.sin(np.radians(360 * (284 + dia_del_anio) / 365))

# Función de Hargreaves and Samani (HS) para calcular la radiación solar
def HS(Ra, Tx, Tn):
    return 0.0023*Ra*np.sqrt(Tx-Tn)


# Función FINAL para calcular la energía generada por las placas
def generacion(radiacion, area, eficiencia):
    return (radiacion*area*eficiencia)

# ------------------------------------------------------------------------------------------------------------------------------ #

# Valores necesarios: D, dm, latitud, dia_del_anio, horas_sol
fechas = []
horas_sol = []
tmax = []
tmin = []

consulta = "SELECT * FROM aemet"
cursor.execute(consulta)

aemet = cursor.fetchall()
for fila in aemet:
    fechas.append(fila[0])
    horas_sol.append(fila[1])
    tmax.append(fila[2])
    tmin.append(fila[3])

#consulta = "SELECT AVG(TotalConsumo) FROM (SELECT DATE(Fecha) AS Fecha, SUM(Consumo) AS TotalConsumo FROM citic GROUP BY DATE(Fecha) ORDER BY TotalConsumo DESC LIMIT 20) AS subconsulta;"

consulta = "SELECT MAX(consumo_mes) FROM (SELECT SUM(consumo) as consumo_mes FROM " + edificio + " WHERE YEAR(Fecha)='2016' GROUP BY MONTH(Fecha) ) AS subconsulta;"

cursor.execute(consulta)
consumo = cursor.fetchall()

# 2013-01-01   ---   2017-12-31
# Diario
registros = len(fechas)

# Datos
generaciones = []
radiacion_solar = []
radiacion_extraterrestre = []
s0 = []
distanciaT_S = []
Ra_en_vatios = []
dm = 1.490006 * 10**11   # Distancia media del sol a la tierra en metros
latitud = 37.1774  # Latitud del lugar en grados

for f in fechas:
    distanciaT_S.append(distancia(f))

for i in range(registros):
    s0.append(parametro_solar(dm,distanciaT_S[i]))

# Cálculo de las radiacion_extraterrestre solares diarias
for i in range(registros):
    radiacion_extraterrestre.append(radiacion_solar_diaria(s0[i], latitud, declinacion_solar(fechas[i].day),horas_sol[i]))

for i in range(registros):
    radiacion_solar.append(HS(radiacion_extraterrestre[i],tmax[i],tmin[i]))

# Pasamos la radiacion_solar de J/m^2 dia a W/m^2
for i in range(registros):
    Ra_en_vatios.append(radiacion_solar[i] / (24 * 3600))

# Hallar el número de paneles necesarios para cubrir la media de los 5 días con mayor consumo
# Se calculará a partir de la media de los 5 días con mayor consumo, la eficiencia de la placa, el area y la media de radiación solar en granada
media_ra = np.mean(Ra_en_vatios)
numero = int(math.ceil(consumo / (media_ra * eficiencia * area)))

for i in range(registros):
    generaciones.append( numero * (generacion(Ra_en_vatios[i],area,eficiencia)) )

# Convertir el tipo de dato de las listas a float
generacion = list(map(float, generaciones))

# Insertar la radiación solar diaria en la base de datos

consulta = "TRUNCATE TABLE generacion"
cursor.execute(consulta)
conexion.commit()

for i in range(registros):
    consulta = "INSERT INTO generacion (Fecha, Generacion) VALUES (%s, %s)"
    valores = (fechas[i], generacion[i])
    cursor.execute(consulta, valores)

print(numero)

conexion.commit()
cursor.close()
# Cerrar la conexión a la base de datos
conexion.close()