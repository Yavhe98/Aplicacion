import mysql.connector
import geojson
import time

def generar_geojson():

    # Establecer la conexión con la base de datos MySQL
    conexion = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="consumo_ugr"
    )

    # Crear un cursor y ejecutar una consulta SQL
    cursor = conexion.cursor()

    # Crear una lista para almacenar las características
    features = []

    edificios = ["citic", "cmaximo", "instrumentacion", "mentecerebro", "politecnico", "politicas"]
    for e in edificios:
        # Consulta para obtener los registros del último mes
        query = "SELECT nombre, latitud, longitud, direccion, web, SUM(Consumo) as consumo_mes FROM(SELECT * FROM " + e + " JOIN datos_edificio USING(id) LIMIT 720) as subconsulta"
        cursor.execute(query)

        # Recorrer los resultados y crear las características GeoJSON
        for (nombre, latitud, longitud, direccion, web, consumo_mes) in cursor:
            # Crear un objeto de geometría de punto
            geometry = geojson.Point((longitud, latitud))

            # Crear una propiedad con los datos adicionales
            properties = {
                "Name": nombre,
                "Address": direccion,
                "URL": web,
                "kWh": int(consumo_mes)
            }

            # Crear una característica GeoJSON con la geometría y las propiedades
            feature = geojson.Feature(geometry=geometry, properties=properties)

            # Agregar la característica a la lista
            features.append(feature)

    # Crear un objeto FeatureCollection GeoJSON con todas las características
    feature_collection = geojson.FeatureCollection(features)

    # Generar el archivo GeoJSON
    with open("data/datos_edificio.geojson", "w") as f:
        geojson.dump(feature_collection, f)

    # Cerrar el cursor y la conexión
    cursor.close()
    conexion.close()

intervalo_tiempo = 3600

while True:
    generar_geojson()
    time.sleep(intervalo_tiempo)