var express = require("express");
var url = require("url");
var router = express.Router();
var mysql = require("mysql");
var moment = require("moment");
var auth = require("../auth");

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "lavatorylogger"
});

function convertTimeToMin(time) {
    var hours = parseInt(time.split(":")[0]);
    var minutes = parseInt(time.split(":")[1]);
    
    return hours * 60 + minutes;
}

router.get('/', function(req, res, next) {
    auth.verifyPass(req, res);
    
    if(req.query.time == "" || req.query.time == null) {
       con.query("SELECT id, time_out, time_in FROM log WHERE date=?;", [req.query.date], function(err, result, fields) {
            if(err) throw err;
            res.render('datetime', {
                date: req.query.date,
                time: "",
                moment: moment,
                data: result
            });
        }); 
    } else {
        var time = convertTimeToMin(req.query.time);
        
        con.query("SELECT id, time_out, time_in FROM log WHERE date=? AND time_out <= ? AND time_in >= ?", [req.query.date, time, time], function(err, result, fields) {
            if(err) throw err;
            res.render('datetime', {
                date: req.query.date,
                time: time,
                moment: moment,
                data: result
            });
        });
    }
    
    
});

module.exports = router;