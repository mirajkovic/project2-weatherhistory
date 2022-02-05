# Project 2: Weather History

- Run it with:
  docker-compose up -d

- Take it down with:
  docker-compose down

- You can access the webserver under:
  web.docker.localhost:3000


**Some additional information:** 
There are two sleep commands inside the metar.py file. 
The first one is to make sure the database is up and running, before the Collector starts the connection to the database. 
The second sleep command is in the for-loop, to not make to many calls to the website - **_for testing purposes this should be changed to a smaller number, otherwise the database will take some time to populate!_**
