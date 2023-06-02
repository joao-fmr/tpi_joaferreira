# tpi_joaferreira
The TPI repository from João Ferreira from FIN2 at ETML.

This is a TPI project create at ETML.
This repository contains a website done in Laravel, an API done in Lumen, and a script Python that collects data with a Dockerfile to build a Docker Image.

The goal of the website is to determine if you can go to the Lake based on wind strength values around the Lake.
These values are being scrapped from the MétéoSuisse website : 
https://www.meteosuisse.admin.ch/services-et-publications/applications/valeurs-mesurees-et-reseaux-de-mesure.html#param=messwerte-windgeschwindigkeit-kmh-10min&lang=fr&station=PRE&chart=hour

A script Python used to scrapped data is executed on a Docker image in a server every 5 minutes.

An API is then used to make requests to the Database to insert and retrieve the data.

The Docker info on how to use the image can be accessed on : 
https://hub.docker.com/repository/docker/joaferreira/lemanride-script/general 
