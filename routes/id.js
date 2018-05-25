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

router.get('/', function(req, res, next) {
    auth.verifyPass(req, res);
    
    con.query("SELECT date, time_out, time_in, bathroom FROM log WHERE id=?;", [req.query.id], function(err, result, fields) {
        if(err) throw err;
        res.render('id', {
            id: req.query.id,
            moment: moment,
            data: result
        });
    });
});

module.exports = router;