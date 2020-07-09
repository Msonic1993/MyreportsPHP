import pyown

own pyown.DWM('1d4f56399e0c047e432fd9fccd10652b')
observation = own.weather_at_place('San Francisco, US')
weather = observation.get_weather()
temperature = weather.get_weather('celsius'[temp']
print('temperatura w jest' +temperature)