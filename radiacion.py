import numpy as np
import mysql.connector
import json
from datetime import datetime, date

# Nos conectamos a la base de datos
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="consumo_ugr"
)
cursor = conexion.cursor()


# Leer el archivo txt con los datos meteorológicos
"""with open("data/aemet.txt", "r") as file:
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

conexion.commit()"""


# -------------------------------------------------------- FUNCIONES ----------------------------------------------------- #

# Función para calcular la radiación solar diaria
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
    return (1.496*10**13) * (1-0.017 * np.sin(0.9856 * D)) # cm

# Función para calcular la declinación solar
def declinacion_solar(dia_del_anio):
    return 23.45 * np.sin(np.radians(360 * (284 + dia_del_anio) / 365))

# Función FINAL de Hargreaves and Samani (HS) para calcular la radiación solar
def HS(Ra, Tx, Tn):
    return 0.0023*Ra*np.sqrt(Tx-Tn)

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



registros = len(fechas)

# Datos
radiacion_solar = []
radiacion_extraterrestre = []
s0 = []
distanciaT_S = []
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

# Convertir el tipo de dato de las listas a float
radiacion_solar = list(map(float, radiacion_solar))

# Insertar la radiación solar diaria en la base de datos
for i in range(registros):
    consulta = "INSERT INTO radiacion_solar (Fecha, Radiacion) VALUES (%s, %s)"
    valores = (fechas[i], radiacion_solar[i])
    cursor.execute(consulta, valores)

conexion.commit()
cursor.close()
# Cerrar la conexión a la base de datos
conexion.close()
