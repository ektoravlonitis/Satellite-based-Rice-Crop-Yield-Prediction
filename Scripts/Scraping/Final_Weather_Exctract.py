import requests
import pandas as pd
import sys
from statistics import mean
from datetime import datetime
from time import sleep


#Creating function to obtain data from 'visual crossing'
def api_call(location, start_date, end_date):
    print('Fetching data for location: {} from {} to {}'.format(location, start_date, end_date))
    #Parameters Example
    # location = 'Thoai_Son' or '38.9697,-77.385'
    # start_date = '2022-03-18'
    # end_date = '2022-07-25'
    key='X4AWPL9FZRZ8BGWTF2QMBKPRW'
    response = requests.request("GET", "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{}/{}/{}?unitGroup=metric&include=days&key={}&contentType=json".format(location, start_date, end_date, key ))
    # while response.status_code == 429:
    #     print('Status Code: {}'.format(response.status_code))
    #     print('Request limit reached.. pausing for some time and attempting to resume afterwards')
    #     #sleep(60*60*3) # 3 hours # propably requires more
    #     sys.exit()
    #     response = requests.request("GET", "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{}/{}/{}?unitGroup=metric&include=days&key=X4AWPL9FZRZ8BGWTF2QMBKPRW&contentType=json".format(location, start_date, end_date ))
    if response.status_code != 200:
      print('Unexpected Status code: ', response.status_code)
      return None

    # Parse the results as JSON
    jsonData = response.json()
    return jsonData['days']

def range_constructor(num):
    '''Takes the number of days and splits it to to 14 sections'''
    part_size = num // 14
    ranges = []
    start = 0
    for _ in range(13):
        new_range = (start , start + part_size)
        ranges.append(new_range)
        start += part_size
    ranges.append((start, num))
    return ranges

def convert_to_seconds(string):
    '''Converts a time of day to seconds'''
    hours = int(string[0:2])
    mins = int(string[3:5])
    secs = int(string[6:8])
    return (hours*60+mins)*60+secs

def transform_to_row(pandas_dataframe):
    '''This function performs a form of aggregation where every column of a dataframe
    is split into 14 sections. Then an aggregation is performed in each section
    to produce one value. Returns a row of 14*number_of_columns elements'''
    result = []
    ranges = range_constructor(len(pandas_dataframe))
    #For these features, average is performed
    temp_list = []
    dew_list = []
    humidity_list = []
    sunlight_duration_list = []
    precip_list = []
    precipcover_list = []
    windgust_list = []
    windspeed_list = []
    pressure_list = []
    cloudcover_list = []
    solarradiation_list = []
    solarenergy_list = []
    uvindex_list = []
    
    #For these features, max or min is performed
    temp_max_list = []
    temp_min_list = []
    
    for r in ranges:
        target = pandas_dataframe.loc[r[0]:r[1]]
        temp_list.append(mean(target['temp']))
        dew_list.append(mean(target['dew']))
        humidity_list.append(mean(target['humidity']))
        sunlight_duration_list.append(mean(target['sunset']-target['sunrise']))
        precip_list.append(mean(target['precip']))
        precipcover_list.append(mean(target['precipcover']))
        windgust_list.append(mean(target['windgust']))
        windspeed_list.append(mean(target['windspeed']))
        pressure_list.append(mean(target['pressure']))
        cloudcover_list.append(mean(target['cloudcover']))
        solarradiation_list.append(mean(target['solarradiation']))
        solarenergy_list.append(mean(target['solarenergy']))
        uvindex_list.append(mean(target['uvindex']))
        
        temp_max_list.append(max(target['tempmax']))
        temp_min_list.append(min(target['tempmin']))
    
    result += temp_max_list
    result += temp_min_list
    
    result += temp_list
    result += dew_list
    result += humidity_list
    result += precip_list
    result += precipcover_list
    result += windgust_list
    result += windspeed_list
    result += pressure_list
    result += cloudcover_list
    result += solarradiation_list
    result += solarenergy_list
    result += uvindex_list
    result += sunlight_duration_list
    
    
    return result
    

#load crop yield data
data=pd.read_csv('Crop_Yield_Data.csv', sep=',')

#to change date format of column 'Date of Harvest'
to_date = lambda x: datetime.strptime(x, '%d-%m-%Y').date()

features=['tempmax', 'tempmin', 'temp', 'dew', 'humidity', 'precip',
          'precipcover', 'windgust', 'windspeed','pressure', 'cloudcover',
          'solarradiation', 'solarenergy', 'uvindex', 'sunrise', 'sunset']

#If file exists, contiue

try:
    final_weather_data = pd.read_csv('Weather Data.csv')
    print('File Found, appending...')

#Else create new Dataframe
except FileNotFoundError:
    print('No file found.. Creating File..')
    Final_features = ['Lattitude', 'Longtitude', 'Season']
    for feat in (features[:-2] + ['Sunlight duration']):
        for week in range(1,15):
            Final_features.append('{} section {}'.format(feat, week))
            
    final_weather_data = pd.DataFrame(columns=Final_features)

#Checkpoint will be 0 if there is no file
checkpoint = len(final_weather_data)


#Fetch the Data
fetched_data = {}
for row in data.values[checkpoint:]:
    lat = row[1]
    long = row[2]
    
    end_date = to_date(row[5])
    
    #Bellow I find or assume the date of seeding (assumption is explained on the report and presentaion)
    
    #'WS' case
    if row[3] == 'WS' :
        start_date = to_date('01-11-2021')
        
    #'SA' case
    else:
        temp = data[(data['Latitude']==lat) \
                    & (data['Longitude']==long) \
                    & (data['Season(SA = Summer Autumn, WS = Winter Spring)']=='WS')]
        #If there is a Date of harvest on the 'WS' season of the location and is after 1-04-2022 it is used
        #else 1-04-2022 is used as the date of seeding
        if len(temp) == 1:
            temp_date = to_date(temp.values[0][5])
            start_date = max(temp_date, to_date('01-04-2022'))
        else:
            start_date = to_date('01-04-2022')
            
    location  = str(lat) +',' +  str(long)
    fetced_data_key = (lat, long, row[3])
    fetced_row_data = api_call(location, start_date, end_date)
    if fetced_row_data == None : 
        if len(fetched_data) == 0 : sys.exit()
        break #Stop when no more data can be collected
    fetched_data[fetced_data_key] = fetced_row_data
    
if fetced_row_data!= None:
    print('All data has been collected... good job')

#Now transform fetched data to a single row for each locaition, season
for d_key in list(fetched_data.keys()):
    lat = d_key[0]
    long = d_key[1]
    seas = d_key[2]
    
    #Initiate the Location and the Season for the row
    row = [lat, long, seas]
    dataframe = pd.DataFrame(fetched_data[d_key])
    
    #Filtering based on our selected weather features
    filtered_df = dataframe[features]
    
    #Calculate the 'Sunlight duration' feature
    filtered_df['sunset'] = filtered_df['sunset'].apply(convert_to_seconds)
    filtered_df['sunrise'] = filtered_df['sunrise'].apply(convert_to_seconds)
    row += transform_to_row(filtered_df)
    final_weather_data.loc[len(final_weather_data)]= row
    
final_weather_data.to_csv('Weather Data.csv', index=False)
final_weather_data.to_excel('Weather Data SHOW.xlsx', index=False)