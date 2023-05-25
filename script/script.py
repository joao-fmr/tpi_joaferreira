"""
    ETML
    Author: João Ferreira
    Date : 25.05.2023
    Description : Script that retrieves weather data from MétéoSuisse and sends it to the API
"""

# Import necessary libraries
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from datetime import datetime
import time
import requests
import pytz
import re

# Set the api store method URL
apiUrl = 'http://lemanride.section-inf.ch/api/public/store'

# Define the xpaths for the elements to extract data from
divClass = '//div[@class="measurement-map__detail-body"]'
valueClass = './/div[@class="measurement-map__detail--value"]'
dateClass = './/div[@class="measurement-map__detail--summary"]'

# Define a dictionary of the station ids with their corresponding names
stations = {'PRE': 'St-Prex', 'CGI': 'Nyon / Changins', 'GVE': 'Genève / Cointrin'}

"""
    Wait for an element to be present on the page
    @param driver : the web driver instance
    @param xpath : the xpath of the element to wait for
    @return : the element found
"""
def waitForElement(driver, xpath):
    wait = WebDriverWait(driver, 10)
    element = wait.until(EC.presence_of_element_located((By.XPATH, xpath)))
    return element


"""
    Extract a value from the page
    @param driver : the web driver instance
    @return : the extracted value as a float
"""
def extractValue(driver):
    div = waitForElement(driver, divClass)
    value = div.find_element(By.XPATH, valueClass).text
    value = float(value.split()[0]) 
    return value

# Create a ChromeOptions object to specify additional options for the Chrome web driver
options = webdriver.ChromeOptions()
# -argument to disable the sandbox security feature
options.add_argument('--no-sandbox')
# -argument to run Chrome in headless mode (without a GUI)
options.add_argument('--headless')
# -argument to prevent crashes when running in a Docker container
options.add_argument('--disable-dev-shm-usage')

# Initialize the Chrome web driver with the specified options
driver = webdriver.Chrome(options=options)
  

# Set the current timezone
timezone = pytz.timezone('Europe/Paris')

# Get the current date and time in the specified timezone 
now = datetime.now(timezone)
# Format the date and time as a string
now = now.strftime("%Y-%m-%d %H:%M:%S")

data = {}

# Go through the stations dictionary
for key in stations:
    stationData = {}

    # Set the URL for the current station's data page on MeteoSuisse website according to the station ID (key)
    response = f'https://www.meteosuisse.admin.ch/static/measured-values-app/index.html#lang=fr&param=messwerte-windgeschwindigkeit-kmh-10min&station={key}&chart=hour'

    # Make a HTTP GET request to get the data in JSON format for the current station 
    directionResponse = requests.get(f'https://www.meteosuisse.admin.ch/product/output/measured-values/chartData/wind_hour/chartData.wind_hour.{key}.fr.json')
    json = directionResponse.json()

    # Load the MeteoSuisse page for the current station in the web driver 
    driver.get(response)
    # Reload the page to make sure all data is loaded correctly 
    driver.execute_script("location.reload()")

    # Wait for and find the div element containing data 
    div = waitForElement(driver, divClass)
    # Extract the entry date from the page 
    entryDate = div.find_element(By.XPATH, dateClass).text 
    
    # Use regex to extract only the date and time from entryDate string, and format it as a string
    entryDateText = re.search(r"\d{1,2}\.\d{1,2}\.\d{4}, \d{2}:\d{2}", entryDate).group()
    entryDate = datetime.strptime(entryDateText, "%d.%m.%Y, %H:%M") # convert to datetime object
    entryDate = entryDate.strftime("%Y-%m-%d %H:%M:%S")

    # Extract wind speed value from page 
    valWindSpeed = extractValue(driver)

    # Find and click on button to switch to "gust" tab 
    button = driver.find_element(By.CSS_SELECTOR, 'label[for="pill_subParams1"]')
    button.click()

    # Extract gust value from page 
    valGust = extractValue(driver)

    # Go through series in json_data 
    for serie in json['series']:
        # Check the series id from the json to see if it corresponds to the wind direction series
        if serie['id'] == f'wind_hour.{key}.fr.series.3':
            # Get the last data point in the series and extract its value
            last_data = serie['data'][-1]
            valWindDirection = last_data[1]

    # Store extracted values in stationData dictionary 
    stationData['valWindSpeed'] = valWindSpeed
    stationData['valWindDirection'] = valWindDirection 
    stationData['valGust'] = valGust
    stationData["valEntryDate"] = entryDate
    stationData["valStoredDate"] = now
    stationData["fkStation"] = key
    
    # Store the station data in the data dictionary according to the station ID
    data[key] = stationData

# Go through the data dictionary and send each sub-dictionary separately to the API
for key in data:
    # Make an HTTP POST request to insert the data into the database
    response = requests.post(apiUrl, json=data[key])

    # Check the status code of the response
    if response.status_code == 201:
        # If the code is 201, the data was inserted successfully
        print('Données insérées avec succès')
    else:
        # If the code is not 201, there was an error inserting the data and the response text wil be printed
        print('Erreur lors de l\'insertion des données')
        print(response.text)