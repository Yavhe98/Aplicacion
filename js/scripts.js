/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


mapboxGl.accessToken = "pk.eyJ1IjoieWF2aGU5OCIsImEiOiJjbGl2bjY1NWowanh0M2RvMmc2OGRzMGMzIn0.SIOffeHb6HvNhYFtwxmn7g";

var map = new mapboxGl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/dark-v9',
    hash: true,
    center: [-3.614042, 37.202174],
    pitch: 45,
    zoom: 15.5
})
// eslint-disable-next-line no-undef
const tb = (window.tb = new Threebox(
    map,
    map.getCanvas().getContext('webgl'),
    {
    defaultLights: true
    }
    ));
     
    map.on('style.load', () => {
    map.addLayer({
    id: 'custom-threebox-model',
    type: 'custom',
    renderingMode: '3d',
    onAdd: function () {
    // Creative Commons License attribution:  Metlife Building model by https://sketchfab.com/NanoRay
    // https://sketchfab.com/3d-models/metlife-building-32d3a4a1810a4d64abb9547bb661f7f3
    const scale = 3.2;
    const options = {
    obj: 'https://docs.mapbox.com/mapbox-gl-js/assets/metlife-building.gltf',
    type: 'gltf',
    scale: { x: scale, y: scale, z: 2.7 },
    units: 'meters',
    rotation: { x: 90, y: -90, z: 0 }
    };
     
    tb.loadObj(options, (model) => {
    model.setCoords([-73.976799, 40.754145]);
    model.setRotation({ x: 0, y: 0, z: 241 });
    tb.add(model);
    });
    },
     
    render: function () {
    tb.update();
    }
    });
    });