#%%
import urllib.request
import time
import mariadb

#%%

time.sleep(60)

try:
	conn = mariadb.connect(
		host="mariadb",
		user="root",
		password="root",
		port=3306,
		database="testdb"
	)

except mariadb.Error as e:
    print(f"Error connecting to MariaDB Platform: {e}")
    

cur = conn.cursor()

#%%
# create dict to lookup codes and names
dicti = {'EDDL' : 'Duesseldorf', 'EDDF' : 'Frankfurt', 'RJAA' : 'Tokio', 'SAEZ' : 'Buenos Aires', 'ENSB' : 'Longyearbyen', 'CYYR' : 'Goose Bay'} 

# iterate over dict entries
while True:
	time.sleep(150)
	for i,j in dicti.items():
		data = urllib.request.urlopen('https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=csv&stationString='+ i +'&hoursBeforeNow=1')
		for line in data:
			content = line.decode("utf-8")
		# split the last line at every whitespace, which seperates all METAR entries, and puts the comma seperated list in one string
		metar = content.split()
		alldata = metar[-1].split(',')
		dt = alldata[2]
		dt = dt.replace('T',' ')
		dt = dt.replace('Z','')
		temperature = alldata[5]
		wind = alldata[8]
		pressure = alldata[11]

		cur.execute(
			"INSERT INTO WeatherData (City, Temperature, Pressure, Wind, MeasureTime) VALUES (?, ?, ?, ?, ?)",
			(j, temperature, pressure, wind, dt)
		)
		conn.commit()

		# now find the string which contains the temperatur 
		# for element in metar:
		# 	if '/' in element:
		# 		res = element.split('/')
		# 		# need the number in front of /
		# 		temperatur = res[0]
		# 		# if it has an M replace it with -
		# 		if 'M' in temperatur:
		# 			temperatur = temperatur.split('M')
		# 			temperatur = '-' + temperatur[1]
		# 		break
		
