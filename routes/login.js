var express = require('express');
var router = express.Router();
var auth = require('../auth');

router.get('/', function(req, res, next) {
    if(req.session.incorrect == null) req.session.incorrect = false;
    
    res.render('login', { incorrect: req.session.incorrect });
});

router.post('/', function(req, res, next) {
    auth.login(req, res);
});

module.exports = router;