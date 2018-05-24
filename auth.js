var password = 'password';

module.exports = {
    verifyPass: function(req, res) {
        if(req.session.password != password) {
            res.redirect("/login");
        }
    },
    login: function(req, res) {
        if(req.body.password == password) {
            req.session.incorrect = false;
            req.session.password = req.body.password;
            res.redirect('/');
        } else {
            req.session.incorrect = true;
            res.redirect('/login');
        }
    },
    secret: "SECRET DONT SHARE"
};