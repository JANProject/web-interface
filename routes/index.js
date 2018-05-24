var express = require('express');
var router = express.Router();
var auth = require("../auth");

/* GET home page. */
router.get('/', function(req, res, next) {
    auth.verifyPass(req, res);
    
    res.render('index');
});

module.exports = router;
