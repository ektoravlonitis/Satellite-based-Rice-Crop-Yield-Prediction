import mysql.connector
from mysql.connector import errorcode
import configparser

config = configparser.ConfigParser()
config.read('../configMysql.ini')

db_config = {
    'user': config.get('mysql', 'user'),
    'password': config.get('mysql', 'password'),
    'host': config.get('mysql', 'host'),
    'port': config.get('mysql', 'port')
}

try:
    cnx = mysql.connector.connect(**db_config)
    cursor = cnx.cursor()

    cursor.execute("CREATE DATABASE IF NOT EXISTS rice_db")
    cursor.execute("USE rice_db")   

    query1 = """
    CREATE TABLE RiceCrop (
        id INT AUTO_INCREMENT PRIMARY KEY,
        District VARCHAR(80),
        Latitude FLOAT,
        Longitude FLOAT,
        `Season(SA = Summer Autumn, WS = Winter Spring)` VARCHAR(80),
        `Rice Crop Intensity(D=Double, T=Triple)` VARCHAR(80),
        `Date of Harvest` DATE,
        `Field size (ha)` FLOAT,
        `Rice Yield (kg/ha)` FLOAT
    )
    """

    query2 = """
    CREATE TABLE Sentinel1 (
        id INT AUTO_INCREMENT PRIMARY KEY,
        min_vh FLOAT,
        min_vv FLOAT,
        max_vh FLOAT,
        max_vv FLOAT,
        range_vh FLOAT,
        range_vv FLOAT,
        mean_vh FLOAT,
        mean_vv FLOAT,
        std_vh FLOAT,
        std_vv FLOAT,
        ratio_vv_vh FLOAT,
        rvi FLOAT
    )
    """

    query3 = """
    CREATE TABLE NDVI (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ndvi FLOAT
    )
    """

    query4 = """
    CREATE TABLE WeatherParameters (
        id INT AUTO_INCREMENT PRIMARY KEY,
        Latitude FLOAT,
        Longitude FLOAT,
        `Season(SA = Summer Autumn, WS = Winter Spring)` VARCHAR(80),
        `tempmax section 1` FLOAT,
        `tempmax section 2` FLOAT,
        `tempmax section 3` FLOAT,
        `tempmax section 4` FLOAT,
        `tempmax section 5` FLOAT,
        `tempmax section 6` FLOAT,
        `tempmax section 7` FLOAT,
        `tempmax section 8` FLOAT,
        `tempmax section 9` FLOAT,
        `tempmax section 10` FLOAT,
        `tempmax section 11` FLOAT,
        `tempmax section 12` FLOAT,
        `tempmax section 13` FLOAT,
        `tempmax section 14` FLOAT,
        `tempmin section 1` FLOAT,
        `tempmin section 2` FLOAT,
        `tempmin section 3` FLOAT,
        `tempmin section 4` FLOAT,
        `tempmin section 5` FLOAT,
        `tempmin section 6` FLOAT,
        `tempmin section 7` FLOAT,
        `tempmin section 8` FLOAT,
        `tempmin section 9` FLOAT,
        `tempmin section 10` FLOAT,
        `tempmin section 11` FLOAT,
        `tempmin section 12` FLOAT,
        `tempmin section 13` FLOAT,
        `tempmin section 14` FLOAT,
        `temp section 1` FLOAT,
        `temp section 2` FLOAT,
        `temp section 3` FLOAT,
        `temp section 4` FLOAT,
        `temp section 5` FLOAT,
        `temp section 6` FLOAT,
        `temp section 7` FLOAT,
        `temp section 8` FLOAT,
        `temp section 9` FLOAT,
        `temp section 10` FLOAT,
        `temp section 11` FLOAT,
        `temp section 12` FLOAT,
        `temp section 13` FLOAT,
        `temp section 14` FLOAT,
        `dew section 1` FLOAT,
        `dew section 2` FLOAT,
        `dew section 3` FLOAT,
        `dew section 4` FLOAT,
        `dew section 5` FLOAT,
        `dew section 6` FLOAT,
        `dew section 7` FLOAT,
        `dew section 8` FLOAT,
        `dew section 9` FLOAT,
        `dew section 10` FLOAT,
        `dew section 11` FLOAT,
        `dew section 12` FLOAT,
        `dew section 13` FLOAT,
        `dew section 14` FLOAT,
        `humidity section 1` FLOAT,
        `humidity section 2` FLOAT,
        `humidity section 3` FLOAT,
        `humidity section 4` FLOAT,
        `humidity section 5` FLOAT,
        `humidity section 6` FLOAT,
        `humidity section 7` FLOAT,
        `humidity section 8` FLOAT,
        `humidity section 9` FLOAT,
        `humidity section 10` FLOAT,
        `humidity section 11` FLOAT,
        `humidity section 12` FLOAT,
        `humidity section 13` FLOAT,
        `humidity section 14` FLOAT,
        `precip section 1` FLOAT,
        `precip section 2` FLOAT,
        `precip section 3` FLOAT,
        `precip section 4` FLOAT,
        `precip section 5` FLOAT,
        `precip section 6` FLOAT,
        `precip section 7` FLOAT,
        `precip section 8` FLOAT,
        `precip section 9` FLOAT,
        `precip section 10` FLOAT,
        `precip section 11` FLOAT,
        `precip section 12` FLOAT,
        `precip section 13` FLOAT,
        `precip section 14` FLOAT,
        `precipcover section 1` FLOAT,
        `precipcover section 2` FLOAT,
        `precipcover section 3` FLOAT,
        `precipcover section 4` FLOAT,
        `precipcover section 5` FLOAT,
        `precipcover section 6` FLOAT,
        `precipcover section 7` FLOAT,
        `precipcover section 8` FLOAT,
        `precipcover section 9` FLOAT,
        `precipcover section 10` FLOAT,
        `precipcover section 11` FLOAT,
        `precipcover section 12` FLOAT,
        `precipcover section 13` FLOAT,
        `precipcover section 14` FLOAT,
        `windgust section 1` FLOAT,
        `windgust section 2` FLOAT,
        `windgust section 3` FLOAT,
        `windgust section 4` FLOAT,
        `windgust section 5` FLOAT,
        `windgust section 6` FLOAT,
        `windgust section 7` FLOAT,
        `windgust section 8` FLOAT,
        `windgust section 9` FLOAT,
        `windgust section 10` FLOAT,
        `windgust section 11` FLOAT,
        `windgust section 12` FLOAT,
        `windgust section 13` FLOAT,
        `windgust section 14` FLOAT,
        `windspeed section 1` FLOAT,
        `windspeed section 2` FLOAT,
        `windspeed section 3` FLOAT,
        `windspeed section 4` FLOAT,
        `windspeed section 5` FLOAT,
        `windspeed section 6` FLOAT,
        `windspeed section 7` FLOAT,
        `windspeed section 8` FLOAT,
        `windspeed section 9` FLOAT,
        `windspeed section 10` FLOAT,
        `windspeed section 11` FLOAT,
        `windspeed section 12` FLOAT,
        `windspeed section 13` FLOAT,
        `windspeed section 14` FLOAT,
        `pressure section 1` FLOAT,
        `pressure section 2` FLOAT,
        `pressure section 3` FLOAT,
        `pressure section 4` FLOAT,
        `pressure section 5` FLOAT,
        `pressure section 6` FLOAT,
        `pressure section 7` FLOAT,
        `pressure section 8` FLOAT,
        `pressure section 9` FLOAT,
        `pressure section 10` FLOAT,
        `pressure section 11` FLOAT,
        `pressure section 12` FLOAT,
        `pressure section 13` FLOAT,
        `pressure section 14` FLOAT,
        `cloudcover section 1` FLOAT,
        `cloudcover section 2` FLOAT,
        `cloudcover section 3` FLOAT,
        `cloudcover section 4` FLOAT,
        `cloudcover section 5` FLOAT,
        `cloudcover section 6` FLOAT,
        `cloudcover section 7` FLOAT,
        `cloudcover section 8` FLOAT,
        `cloudcover section 9` FLOAT,
        `cloudcover section 10` FLOAT,
        `cloudcover section 11` FLOAT,
        `cloudcover section 12` FLOAT,
        `cloudcover section 13` FLOAT,
        `cloudcover section 14` FLOAT,
        `solarradiation section 1` FLOAT,
        `solarradiation section 2` FLOAT,
        `solarradiation section 3` FLOAT,
        `solarradiation section 4` FLOAT,
        `solarradiation section 5` FLOAT,
        `solarradiation section 6` FLOAT,
        `solarradiation section 7` FLOAT,
        `solarradiation section 8` FLOAT,
        `solarradiation section 9` FLOAT,
        `solarradiation section 10` FLOAT,
        `solarradiation section 11` FLOAT,
        `solarradiation section 12` FLOAT,
        `solarradiation section 13` FLOAT,
        `solarradiation section 14` FLOAT,
        `solarenergy section 1` FLOAT,
        `solarenergy section 2` FLOAT,
        `solarenergy section 3` FLOAT,
        `solarenergy section 4` FLOAT,
        `solarenergy section 5` FLOAT,
        `solarenergy section 6` FLOAT,
        `solarenergy section 7` FLOAT,
        `solarenergy section 8` FLOAT,
        `solarenergy section 9` FLOAT,
        `solarenergy section 10` FLOAT,
        `solarenergy section 11` FLOAT,
        `solarenergy section 12` FLOAT,
        `solarenergy section 13` FLOAT,
        `solarenergy section 14` FLOAT,
        `uvindex section 1` FLOAT,
        `uvindex section 2` FLOAT,
        `uvindex section 3` FLOAT,
        `uvindex section 4` FLOAT,
        `uvindex section 5` FLOAT,
        `uvindex section 6` FLOAT,
        `uvindex section 7` FLOAT,
        `uvindex section 8` FLOAT,
        `uvindex section 9` FLOAT,
        `uvindex section 10` FLOAT,
        `uvindex section 11` FLOAT,
        `uvindex section 12` FLOAT,
        `uvindex section 13` FLOAT,
        `uvindex section 14` FLOAT,
        `Sunlight duration section 1` FLOAT,
        `Sunlight duration section 2` FLOAT,
        `Sunlight duration section 3` FLOAT,
        `Sunlight duration section 4` FLOAT,
        `Sunlight duration section 5` FLOAT,
        `Sunlight duration section 6` FLOAT,
        `Sunlight duration section 7` FLOAT,
        `Sunlight duration section 8` FLOAT,
        `Sunlight duration section 9` FLOAT,
        `Sunlight duration section 10` FLOAT,
        `Sunlight duration section 11` FLOAT,
        `Sunlight duration section 12` FLOAT,
        `Sunlight duration section 13` FLOAT,
        `Sunlight duration section 14` FLOAT
    )
    """

    cursor.execute(query1)
    cursor.execute(query2)
    cursor.execute(query3)
    cursor.execute(query4)

    cnx.commit()
    
except mysql.connector.Error as err:
    if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
        print("Something is wrong with your user name or password")
    elif err.errno == errorcode.ER_BAD_DB_ERROR:
        print("Database does not exist")
    else:
        print(err)

finally:
    if cnx:
        cnx.close()
