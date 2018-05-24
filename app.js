var createError = require('http-errors');
var express = require('express');
var path = require('path');
var favicon = require("serve-favicon");
var cookieParser = require('cookie-parser');
var logger = require('morgan');
var mysql = require('mysql');

var index = require('./routes/index');
var id = require('./routes/id')
var datetime = require('./routes/datetime')

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "lavatorylogger"
});

var app = express();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

app.use(favicon(__dirname + "/public/favicon.png"))

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', index);
app.use('/id', id);
app.use('/datetime', datetime);

app.post('/post', function(req, res) {
    con.query("UPDATE log SET time_in=? WHERE date=? AND id=? AND time_in IS NULL;", [req.body.time, req.body.date, req.body.id], function(err, result, fields) {
        if(err) throw err;
        
        if(result.changedRows == 0) {
            con.query("INSERT INTO log VALUES(?, ?, ?, NULL);", [req.body.id, req.body.date, req.body.time], function(err, result, fields) {
                if(err) throw err;
                
                res.send("Success - Added row");
            });
        } else {
            res.send("Success - Updated with time_in");
        }
    });
});

// catch 404 and forward to error handler
app.use(function(req, res, next) {
    next(createError(404));
});

// error handler
app.use(function(err, req, res, next) {
    // set locals, only providing error in development
    res.locals.message = err.message;
    res.locals.error = req.app.get('env') === 'development' ? err : {};
    
    // render the error page
    res.status(err.status || 500);
    res.render('error');
});

module.exports = app;
