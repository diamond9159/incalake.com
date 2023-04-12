# IncalakeMap

Una Biblioteca diseñada para crear mapas de una manera sencilla y rapida.

## Crear un mapa
Para ello creamos una instancia de la clase `IncalakeMap`, su constructor recibe como argumento el id del div en el template, el cual será reemplazado luego con el mapa.

    var mapa1 = new IncalakeMap('map');
    
Luego tenemos que agregar las paradas (waypoints), las cuales estan en un formato como el siguente:

    var waypoints = [
        {
            "nombre": "Machu Picchu",
            "coordenadas": "-13.1631, -72.5450",
            "tipo": "4",
            "orden" :"1"
        },
        {
            "nombre": "Puno",
            "coordenadas": "-13.1631, -71.5450",
            "tipo": "5",
            "orden" :"2"
        },
    ];
  > El tipo de los waypoints son los siguentes:
  > 0: airport
  > 1: busStation
  > 2: hotel
  > 3: houseChanging
  > 4: museum
  > 5: port
  > 6: restaurant
  > 7: ruins
  > 8: sightseeing
  > 9: square
  > 10: trainStation
  Ademas, estos tienen iconos(con el mismo nombre), que se encuentran en la carpeta 'mapIcons', por lo cual se tienen que pasar el base_url de la carpeta al metodo `setBaseUrl()`
  
Para agregar los waypoints al mapa, la clase `IncalakeMap` cuenta con el metodo `addWaypoints()`, cuyo argumento son los waypoints.

    mapa1.addWaypoints(waypoints);

Finalmente para mostrar el mapa, la clase `IncalakeMap` cuenta con el metodo `showNumberedMarkers()`. 
## A continuacion se muestra un ejemplo:
    
    var waypoints = [
        {
        "nombre": "Uros, Puno, Peru",
        "coordenadas": "-15.8186675,-69.9689917",
        "tipo": "1",
        "orden" :"4"
        },
        {
        "nombre": "Plaza de Armas Puno",
        "coordenadas": "-15.840646104912787, -70.02789616584778",
        "tipo": "22",
        "orden" :"2"
        },
        {
        "nombre": "Puerto Puno",
        "coordenadas": "-15.835421858694973, -70.0149514675195",
        "tipo": "5",
        "orden" :"3"
        },
        {
        "nombre": "Sillustani",
        "coordenadas": "-15.721378122244891, -70.1590347290039",
        "tipo": "4",
        "orden" :"1"
        },
        {
        "nombre": "Uyuni",
        "coordenadas": "-20.4604, -66.8261",
        "tipo": "10",
        "orden" :"5"
        }
    ];

    var mapa1 = new IncalakeMap('map');
    mapa1.setBaseUrl('http://localhost/web/icons');
    mapa1.addWaypoints(waypoints); 
    mapa1.showNumberedMarkers();
    