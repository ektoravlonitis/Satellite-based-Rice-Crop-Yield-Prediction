import mysql.connector
from mysql.connector import errorcode
import configparser
import csv

# Read database configuration from configMysql.ini
config = configparser.ConfigParser()
config.read('../configMysql.ini')

db_config = {
    'user': config.get('mysql', 'user'),
    'password': config.get('mysql', 'password'),
    'host': config.get('mysql', 'host'),
    'port': config.get('mysql', 'port'),
    'database': 'rice_db'
}

try:
    # Connect to the database
    cnx = mysql.connector.connect(**db_config)
    cursor = cnx.cursor()

    # Function to insert data from a CSV file into a table
    def insert_data_from_csv(file_path, table_name, column_names):
        with open(file_path, 'r') as file:
            csv_data = csv.reader(file)
            next(csv_data)  # Skip the header row

            insert_query = f"INSERT INTO {table_name} ({', '.join(column_names)}) VALUES ({', '.join(['%s'] * len(column_names))})"
            records_to_insert = []

            for row in csv_data:
                records_to_insert.append(tuple(row))

                # Insert records in batches of 1000
                if len(records_to_insert) == 1000:
                    cursor.executemany(insert_query, records_to_insert)
                    records_to_insert.clear()

            # Insert any remaining records
            if records_to_insert:
                cursor.executemany(insert_query, records_to_insert)

            cnx.commit()

    # Insert data into RiceCrop table
    rice_crop_file = 'rice_crop_data.csv'
    rice_crop_columns = ['District', 'Latitude', 'Longitude', 'Season(SA = Summer Autumn, WS = Winter Spring)',
                         'Rice Crop Intensity(D=Double, T=Triple)', 'Date of Harvest', 'Field size (ha)',
                         'Rice Yield (kg/ha)']
    insert_data_from_csv(rice_crop_file, 'RiceCrop', rice_crop_columns)

    # Insert data into Sentinel1 table
    sentinel1_file = 'sentinel1_data.csv'
    sentinel1_columns = ['min_vh', 'min_vv', 'max_vh', 'max_vv', 'range_vh', 'range_vv', 'mean_vh', 'mean_vv',
                         'std_vh', 'std_vv', 'ratio_vv_vh', 'rvi', 'main_id']
    insert_data_from_csv(sentinel1_file, 'Sentinel1', sentinel1_columns)

    # Insert data into NDVI table
    ndvi_file = 'ndvi_data.csv'
    ndvi_columns = ['ndvi', 'main_id']
    insert_data_from_csv(ndvi_file, 'NDVI', ndvi_columns)

    # Insert data into WeatherParameters table
    weather_file = 'weather_data.csv'
    weather_columns = ['Latitude', 'Longitude', 'Season(SA = Summer Autumn, WS = Winter Spring)',
                       'tempmax section 1', 'tempmax section 2', 'tempmax section 3', 'tempmax section 4',
                       'tempmax section 5', 'tempmax section 6', 'tempmax section 7', 'tempmax section 8',
                       'tempmax section 9', 'tempmax section 10', 'tempmax section 11', 'tempmax section 12',
                       'tempmax section 13', 'tempmax section 14', 'tempmin section 1', 'tempmin section 2',
                       'tempmin section 3', 'tempmin section 4', 'tempmin section 5', 'tempmin section 6',
                       'tempmin section 7', 'tempmin section 8', 'tempmin section 9', 'tempmin section 10',
                       'tempmin section 11', 'tempmin section 12', 'tempmin section 13', 'tempmin section 14',
                       'temp section 1', 'temp section 2', 'temp section 3', 'temp section 4', 'temp section 5',
                       'temp section 6', 'temp section 7', 'temp section 8', 'temp section 9', 'temp section 10',
                       'temp section 11', 'temp section 12', 'temp section 13', 'temp section 14', 'dew section 1',
                       'dew section 2', 'dew section 3', 'dew section 4', 'dew section 5', 'dew section 6',
                       'dew section 7', 'dew section 8', 'dew section 9', 'dew section 10', 'dew section 11',
                       'dew section 12', 'dew section 13', 'dew section 14', 'humidity section 1', 'humidity section 2',
                       'humidity section 3', 'humidity section 4', 'humidity section 5', 'humidity section 6',
                       'humidity section 7', 'humidity section 8', 'humidity section 9', 'humidity section 10',
                       'humidity section 11', 'humidity section 12', 'humidity section 13', 'humidity section 14',
                       'precip section 1', 'precip section 2', 'precip section 3', 'precip section 4',
                       'precip section 5', 'precip section 6', 'precip section 7', 'precip section 8',
                       'precip section 9', 'precip section 10', 'precip section 11', 'precip section 12',
                       'precip section 13', 'precip section 14', 'precipcover section 1', 'precipcover section 2',
                       'precipcover section 3', 'precipcover section 4', 'precipcover section 5', 'precipcover section 6',
                       'precipcover section 7', 'precipcover section 8', 'precipcover section 9', 'precipcover section 10',
                       'precipcover section 11', 'precipcover section 12', 'precipcover section 13',
                       'precipcover section 14', 'windgust section 1', 'windgust section 2', 'windgust section 3',
                       'windgust section 4', 'windgust section 5', 'windgust section 6', 'windgust section 7',
                       'windgust section 8', 'windgust section 9', 'windgust section 10', 'windgust section 11',
                       'windgust section 12', 'windgust section 13', 'windgust section 14', 'windspeed section 1',
                       'windspeed section 2', 'windspeed section 3', 'windspeed section 4', 'windspeed section 5',
                       'windspeed section 6', 'windspeed section 7', 'windspeed section 8', 'windspeed section 9',
                       'windspeed section 10', 'windspeed section 11', 'windspeed section 12', 'windspeed section 13',
                       'windspeed section 14', 'pressure section 1', 'pressure section 2', 'pressure section 3',
                       'pressure section 4', 'pressure section 5', 'pressure section 6', 'pressure section 7',
                       'pressure section 8', 'pressure section 9', 'pressure section 10', 'pressure section 11',
                       'pressure section 12', 'pressure section 13', 'pressure section 14', 'cloudcover section 1',
                       'cloudcover section 2', 'cloudcover section 3', 'cloudcover section 4', 'cloudcover section 5',
                       'cloudcover section 6', 'cloudcover section 7', 'cloudcover section 8', 'cloudcover section 9',
                       'cloudcover section 10', 'cloudcover section 11', 'cloudcover section 12', 'cloudcover section 13',
                       'cloudcover section 14', 'solarradiation section 1', 'solarradiation section 2',
                       'solarradiation section 3', 'solarradiation section 4', 'solarradiation section 5',
                       'solarradiation section 6', 'solarradiation section 7', 'solarradiation section 8',
                       'solarradiation section 9', 'solarradiation section 10', 'solarradiation section 11',
                       'solarradiation section 12', 'solarradiation section 13', 'solarradiation section 14',
                       'solarenergy section 1', 'solarenergy section 2', 'solarenergy section 3',
                       'solarenergy section 4', 'solarenergy section 5', 'solarenergy section 6',
                       'solarenergy section 7', 'solarenergy section 8', 'solarenergy section 9',
                       'solarenergy section 10', 'solarenergy section 11', 'solarenergy section 12',
                       'solarenergy section 13', 'solarenergy section 14', 'uvindex section 1', 'uvindex section 2',
                       'uvindex section 3', 'uvindex section 4', 'uvindex section 5', 'uvindex section 6',
                       'uvindex section 7', 'uvindex section 8', 'uvindex section 9', 'uvindex section 10',
                       'uvindex section 11', 'uvindex section 12', 'uvindex section 13', 'uvindex section 14',
                       'Sunlight duration section 1', 'Sunlight duration section 2', 'Sunlight duration section 3',
                       'Sunlight duration section 4', 'Sunlight duration section 5', 'Sunlight duration section 6',
                       'Sunlight duration section 7', 'Sunlight duration section 8', 'Sunlight duration section 9',
                       'Sunlight duration section 10', 'Sunlight duration section 11', 'Sunlight duration section 12',
                       'Sunlight duration section 13', 'Sunlight duration section 14', 'main_id']
    insert_data_from_csv(weather_file, 'WeatherParameters', weather_columns)

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
