## Weather API integration

Provide a city name, and the app will geolocate it, then will display current forecast using available APIs 
(default 2, but you can add as many as you like) all the data in the forecast are displayed as an average 
of API calls results. 
System stores geolocation in Database for further use 
(to prevent unnecessary API calls as cities can't move ;-) ). Forecasts are stored in DB and cached for 2 minutes. 

- [On-line demo](http://tasks.g0f.pl/).

####Used APIs:  
- [Geolocation API](http://api.openweathermap.org/geo/1.0/)
- [Openweathermap.org](https://api.openweathermap.org/data/2.5/)
- [Weatherapi.org](http://api.weatherapi.com/v1/)

Laravel 9.48.0 
