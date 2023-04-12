//####################### clase IncalakeMap #############################
var IncalakeMap = (function () {
    //************************ Constructor de la clase *************************
    function IncalakeMap(divId) {
        this.divId = divId;
        this.waypoints = [];
        this.numberedMarkers = [];
        this.iconedMarkers = [];
        this.infowindows = [];
        this.base_url = '';
        this.center = { lat: -15.8468537, lng: -70.0533267 };
        this.map = new google.maps.Map(document.getElementById(this.divId), { zoom: 10, center: this.center, mapTypeId: google.maps.MapTypeId.ROADMAP, zoomControl: false });
        this.addIconedControl();
        this.addNumberedControl();
        this.addRouteControl();
        this.directionsService = new google.maps.DirectionsService;
        this.directionsDisplay = new google.maps.DirectionsRenderer;
        this.directionsDisplay.setMap(this.map);
        this.kindOfWaypoints = [
            'airport',
            'busStation',
            'hotel',
            'houseChanging',
            'museum',
            'port',
            'restaurant',
            'ruins',
            'sightseeing',
            'square',
            'trainStation'
        ];
        setTimeout(()=>{
           // console.log('controles: ', this.map.controls);
        },3000);
    }
    //************************ Agrega los waypoints desde un array *************************
    IncalakeMap.prototype.addWaypoints = function (waypoints) {
        var _this = this;
        waypoints.forEach(function (waypoint) {
            var w = {
                nombre: waypoint.nombre,
                lat: Number(waypoint.coordenadas.split(",")[0]),
                lng: Number(waypoint.coordenadas.split(",")[1]),
                tipo: Number(waypoint.tipo),
                orden: Number(waypoint.orden)
            };
            _this.waypoints.push(w);
        });
        this.sortWaypoints();
    };
    //************************ ordena los waypoints y crea markers *************************
    IncalakeMap.prototype.sortWaypoints = function () {
        var _this = this;
        if (this.waypoints.length < 1)
            return;
        this.waypoints.sort(function (a, b) {
            if (a.orden < b.orden)
                return -1;
            if (a.orden > b.orden)
                return 1;
            return 0;
        });
        var east = null, west = null, north = null, south = null;
        var image = {
            url: '',
            size: new google.maps.Size(30, 50),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(15, 50)
        };
        this.waypoints.forEach(function (w, i, a) {
            if (w.tipo >= 0 && w.tipo <= 10)
                image.url = _this.base_url + "/mapIcons/" + _this.kindOfWaypoints[w.tipo] + ".png";
            else
                image.url = _this.base_url + "/mapIcons/otro.png";
            _this.iconedMarkers[i] = new google.maps.Marker({
                position: { lat: w.lat, lng: w.lng },
                title: w.nombre,
                icon: image
            });
            _this.numberedMarkers[i] = new google.maps.Marker({
                position: { lat: w.lat, lng: w.lng },
                title: w.nombre,
                label: (i + 1).toString()
            });
            _this.infowindows[i] = new google.maps.InfoWindow({
                position: { lat: w.lat, lng: w.lng },
                content: w.nombre
            });
            _this.numberedMarkers[i].addListener('click', function () {
                _this.infowindows[i].open(_this.map, _this.numberedMarkers[i]);
            });
            _this.iconedMarkers[i].addListener('click', function () {
                _this.infowindows[i].open(_this.map, _this.iconedMarkers[i]);
            });
            if (!north || north < w.lat)
                north = w.lat;
            if (!south || south > w.lat)
                south = w.lat;
            if (!east || east < w.lng)
                east = w.lng;
            if (!west || west > w.lng)
                west = w.lng;
        });
        //console.log('east,west,north,south:',east,west,north,south);
        //console.log('north-south',north-south,'east-west',east-west);
        this.center.lat = (north + south) / 2;
        this.center.lng = (east + west) / 2;
        var ancho = Math.abs(east - west);
        var alto = Math.abs(north - south);
        var tamanio = ancho > alto ? ancho : alto;
        tamanio = Math.abs(Math.round(tamanio));
        this.map.setZoom(10 - tamanio);
        this.map.setCenter(this.center);
      //  console.log('nuevo zoom', 10 - tamanio);
      //  console.log('nuevo centro', this.center);
    };
    //************************ Metodo que crea el boton (1 de 3) *************************
    IncalakeMap.prototype.addNumberedControl = function () {
        var _this = this;
        var controlDiv = document.createElement('div');
        // Cofiguramos CSS para el exterior del control
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '1px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Click para mostrar markers numerados';
        controlDiv.appendChild(controlUI);
        // Configuramos CSS para el interior del control
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '16px';
        controlText.style.lineHeight = '38px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = 'Marcadores';
        controlUI.appendChild(controlText);
        // Configuramos el evento click para volver al centro
        controlUI.addEventListener('click', function () {
            _this.showNumberedMarkers();
        });
        controlDiv.index = 1;
        this.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);
    };
    //************************ Metodo para crear el boton(2 de 3) *************************
    IncalakeMap.prototype.addIconedControl = function () {
        var _this = this;
        var controlDiv = document.createElement('div');
        // Cofiguramos CSS para el exterior del control
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '1px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Click para mostrar iconos de paradas';
        controlDiv.appendChild(controlUI);
        // Configuramos CSS para el interior del control
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '16px';
        controlText.style.lineHeight = '38px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = 'Paradas';
        controlUI.appendChild(controlText);
        // Configuramos el evento click para volver al centro
        controlUI.addEventListener('click', function () {
            _this.showIconedMarkers();
        });
        controlDiv.index = 1;
        this.map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
    };
    //************************ Metodo para agregar el boton(3 de 3) *************************
    IncalakeMap.prototype.addRouteControl = function () {
        var _this = this;
        var controlDiv = document.createElement('div');
        // Cofiguramos CSS para el exterior del control
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '1px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Aqui puedes ver la ruta posible';
        controlDiv.appendChild(controlUI);
        // Configuramos CSS para el interior del control
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '16px';
        controlText.style.lineHeight = '38px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = 'Ruta';
        controlUI.appendChild(controlText);
        // Configuramos el evento click para dibujar la ruta, si no se puede solo dibujamos marcadores
        controlUI.addEventListener('click', function () {
            _this.directionsService.route({
                origin: { lat: _this.waypoints[0].lat, lng: _this.waypoints[0].lng },
                destination: { lat: _this.waypoints[_this.waypoints.length - 1].lat, lng: _this.waypoints[_this.waypoints.length - 1].lng },
                waypoints: _this.waypoints.filter(function (w, i, a) { if (i == 0 || i == a.length - 1)
                    return false; return true; }).map(function (w) { return { location: { lat: w.lat, lng: w.lng }, stopover: true }; }),
                optimizeWaypoints: false,
                travelMode: 'DRIVING'
            }, function (response, status) {
                if (status === 'OK') {
                    _this.directionsDisplay.setMap(_this.map);
                    _this.iconedMarkers.forEach(function (m, i, a) {
                        m.setMap(null);
                    });
                    _this.numberedMarkers.forEach(function (m, i, a) {
                        m.setMap(null);
                    });
                    _this.directionsDisplay.setDirections(response);
                }
                else {
                    _this.map.setCenter(_this.center);
                    _this.showNumberedMarkers();
                }
            });
        });
        controlDiv.index = 1;
        this.map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
    };
    //************************ Metodo que muestra markers con icono *************************
    IncalakeMap.prototype.showIconedMarkers = function () {
        var _this = this;
        this.numberedMarkers.forEach(function (m) {
            m.setMap(null);
        });
        this.directionsDisplay.setMap(null);
        this.iconedMarkers.forEach(function (m) {
            m.setMap(_this.map);
        });
    };
    //************************ Metodo que muestra markers con numeros *************************
    IncalakeMap.prototype.showNumberedMarkers = function () {
        var _this = this;
        this.iconedMarkers.forEach(function (m) {
            m.setMap(null);
        });
        this.directionsDisplay.setMap(null);
        this.numberedMarkers.forEach(function (m) {
            m.setMap(_this.map);
        });
    };
    //************************ Metodo que configura la url para imagenes ****************
    IncalakeMap.prototype.setBaseUrl = function (base_url) {
        var _this = this;
        _this.base_url = base_url;
    };
    return IncalakeMap;
}());
