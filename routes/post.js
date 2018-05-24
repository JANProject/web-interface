var express = require('express');
var router = express.Router();
var mysql = require("mysql");
var auth = require('../auth');

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "lavatorylogger"
});

router.post('/', function(req, res) {
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

module.exports = router;