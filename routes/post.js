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
    if(req.body.bathroom != null) {
        con.query("UPDATE log SET bathroom=? WHERE id=? AND date=? AND time_out <= ? AND time_in IS NULL", [req.body.bathroom, req.body.id, req.body.date, req.body.time], function(err, result, fields) {
            if(err) {
                res.send(err);
                return;
            }
            
            if(result.changedRows != 0) {
                res.send("Success - Updated with bathroom");
            } else {
                res.send("Error - No match for date and time")
            }
        });
    } else {
        con.query("UPDATE log SET time_in=? WHERE date=? AND id=? AND time_in IS NULL;", [req.body.time, req.body.date, req.body.id], function(err, result, fields) {
            if(err) {
                res.send(err);
                return;
            }
            
            if(result.changedRows == 0) {
                con.query("INSERT INTO log VALUES(?, ?, ?, NULL, NULL);", [req.body.id, req.body.date, req.body.time], function(err, result, fields) {
                    if(err) {
                        res.send(err);
                        return;
                    }
                    
                    res.send("Success - Added row");
                });
            } else {
                res.send("Success - Updated with time_in");
            }
        });
    }
});

module.exports = router;