# Este archivo sólo se llamará desde index.php para registrar en la base de datos el tipo y el número de placas de la que se disponen

import numpy as np
import mysql.connector
import json
from datetime import datetime, date
import sys
import math

if len(sys.argv) != 4:
    print("Error: Se requieren tres parámetros. No", len(sys.argv)-1)
    sys.exit(1)

eficiencia = float(sys.argv[1])
area = float(sys.argv[2])
edificio = sys.argv[3]

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

def seno_en_grados(angulo_grados):
    angulo_radianes = np.radians(angulo_grados)
    seno = np.sin(angulo_radianes)
    return seno

def coseno_en_grados(angulo_grados):
    angulo_radianes = np.radians(angulo_grados)
    coseno = np.cos(angulo_radianes)
    return coseno

# checked
def calcular_distancia_tierra_sol(fecha):
    # Convertir la fecha en formato 'yyyy-mm-dd' a día y mes
    dia = fecha.day
    mes = fecha.month

    # Calcular el valor de θ (ángulo polar)
    def calcular_theta(dia, mes):
        # Calcular el número de días transcurridos desde el 1 de enero
        dias_transcurridos = sum([31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30][:mes-1]) + dia

        # Calcular la anomalía media (M)
        M = 2 * math.pi * (dias_transcurridos - 182.5) / 365.24219

        # Calcular la ecuación del tiempo (E)
        K = 0.017202  # Constante para el número de días transcurridos desde el equinoccio vernal
        E = K * seno_en_grados(2 * M) + 1.914 * seno_en_grados(M) + 0.02 * seno_en_grados(2 * M)

        # Calcular el valor de θ
        theta = M + E

        return theta

    # Calcular la distancia de la Tierra al Sol
    def calcular_distancia(theta):
        a = 149.6 * 10**6  # Semieje mayor de la órbita terrestre en kilómetros
        e = 0.0167  # Excentricidad de la órbita terrestre

        r = a * (1 - e**2) / (1 + e * coseno_en_grados(theta))
        return r * 1000  # Convertir de kilómetros a metros

    # Calcular θ para la fecha especificada
    theta = calcular_theta(dia, mes)

    # Calcular la distancia entre la Tierra y el Sol
    distancia = calcular_distancia(theta)

    return distancia


# Ejemplo de uso
#fecha = '2023-06-28'
#distancia_tierra_sol = calcular_distancia_tierra_sol(fecha)
#print("Distancia de la Tierra al Sol:", distancia_tierra_sol, "metros")

# Función para calcular la radiación solar diaria extreaterrestre J/m^2/dia
def radiacion_solar_diaria(s0, latitud, declinacion, h_sol):
    radiacion_solar_diaria = s0 * 3600 * (seno_en_grados(90 - latitud + declinacion)) * (2 * h_sol / np.pi)
    return radiacion_solar_diaria

# Funcion para calcular el parámetro solar S0
def parametro_solar(dm, d):
    return 1367 * (dm/d)**2; # W/m^2

"""# Funcion para calcular la distancia de la tierra al Sol en una fecha concreta
# D es el número de días desde el 22 de marzo
def distancia(fecha):
    f_inicial = date(fecha.year, 3, 22)
    D = (fecha - f_inicial).days
    #if D < 0
    return (1.496*10**11) * (1-0.017 * np.sin(0.9856 * D)) # metros"""

# Función para calcular la declinación solar
def declinacion_solar(fecha):
    fecha_actual = datetime.combine(fecha, datetime.min.time())  # Convertir a objeto datetime
    fecha_referencia = datetime(fecha.year, 1, 1)  # Fecha de referencia (22 de marzo)
    dias_transcurridos = (fecha_actual - fecha_referencia).days
    # Calcular la declinación solar
    
    return 23.45 * coseno_en_grados(360*(dias_transcurridos-172)/365)

# Función de Hargreaves and Samani (HS) para calcular la radiación solar
# being recommended the use of 0.16 and 0.19 in KT for inland and coastal locations, respectively
def HS(Ra, Tx, Tn):
    return 0.19*Ra*(np.sqrt(Tx-Tn))


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

consulta = "SELECT MAX(consumo_mes) FROM(SELECT SUM(consumo) as consumo_mes, Fecha FROM	" + edificio + " GROUP BY YEAR(Fecha), MONTH(Fecha) ) AS subconsulta;"

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
dm = 1.490006 * 10**11   # Distancia media del sol a la tierra en metros
latitud = 37.1774  # Latitud del lugar en grados
Ra_en_vatios = []


# Calculo de la distancia de la tierra al sol para cada día del año
for f in fechas:
    distanciaT_S.append(calcular_distancia_tierra_sol(f))

# Calculo del parámetro solar s0 para cada día del año
for i in range(registros):
    s0.append(parametro_solar(dm,distanciaT_S[i]))

# Cálculo de las radiacion_extraterrestre solares para cada día del año
for i in range(registros):
    radiacion_extraterrestre.append(radiacion_solar_diaria(s0[i], latitud, declinacion_solar(fechas[i]), horas_sol[i]))

# Pasamos la radiacion_solar de J/m^2 dia a W/m^2
for i in range(registros):
    Ra_en_vatios.append(radiacion_extraterrestre[i] / (24 * 3600))

# Caculo de la radiacion en un punto mediante la ecuación de HS y pasando los J/m^2 a MJ/m^2
for i in range(registros):
    radiacion_solar.append(HS(Ra_en_vatios[i],tmax[i],tmin[i]))

# Hallar el número de paneles necesarios para cubrir la media de los 5 días con mayor consumo
# Se calculará a partir de la media de los 5 días con mayor consumo, la eficiencia de la placa, el area y la media de radiación solar en granada
consulta = "SELECT DISTINCT(area) FROM datos_edificio JOIN " + edificio + " USING(id);"

cursor.execute(consulta)
area_edificio = cursor.fetchone()
area_edificio=area_edificio[0]
media_ra = np.mean(Ra_en_vatios)*30
numero = int(math.ceil(consumo / (media_ra * eficiencia * area)))


# No caben todos los paneles
if(numero * area > area_edificio):
    numero_real = math.floor(area_edificio/area)
    for i in range(registros):
        generaciones.append( numero_real * (generacion(Ra_en_vatios[i],area,eficiencia)) )
else:
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

# Se imprime el numero de placas necesario para una generación sin costes
print(numero)


conexion.commit()
cursor.close()
# Cerrar la conexión a la base de datos
conexion.close()

