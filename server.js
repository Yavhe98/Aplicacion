var express = require('express');
var app = express();

app.set('view engine', 'ejs');

app.get("/", (req, res)=>{
    res.render('index.html',{});
});

app.listen(3000, function() {
    console.log('App de ejemplo escuchando en el puerto 3000')
});