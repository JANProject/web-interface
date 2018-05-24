var createError = require('http-errors');
var express = require('express');
var path = require('path');
var favicon = require("serve-favicon");
var cookieParser = require('cookie-parser');
var logger = require('morgan');
var mysql = require('mysql');
var session = require("express-session");
var validator = require("express-validator");
var auth = require("./auth");

var index = require('./routes/index');
var id = require('./routes/id');
var datetime = require('./routes/datetime');
var login = require('./routes/login');
var post = require('./routes/post')
var logout = require('./routes/logout')

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

var sess = {
    secret: auth.secret,
    saveUninitialized: false,
    resave: false
};

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(validator());
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));
app.use(session(sess));

app.use('/', index);
app.use('/id', id);
app.use('/datetime', datetime);
app.use('/login', login);
app.use('/post', post);
app.use('/logout', logout);

if(app.get('env') === 'production') {
  app.set('trust proxy', 1) // trust first proxy
  sess.cookie.secure = true // serve secure cookies
}

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
