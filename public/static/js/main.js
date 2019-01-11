
popup.init() // 初始化弹出层

/**
 * 管理员登录验证
 * @param {*} username 
 * @param {*} password 
 * @param {*} captcha
 */
var adminLogin = function (username, password, captcha) {
    username = $.trim(username)
    password = $.trim(password)
    captcha = $.trim(captcha)
    if (username == "" || password == "" || captcha == "") {
        popup.msg('用户名密码验证码不能为空', 'no')
    } else {
        var load = popup.load('验证中...')
        $.post('/api/admin/login', {
            username: username,
            password: password,
            captcha: captcha
        }, function (res) {
            popup.close(load)
            var data = JSON.parse(res)
            if (data.state == "success") {
                document.location.href = "/admin"
            } else {
                popup.msg('用户名密码验证码错误', 'cry')
                reloadCaptcha()
            }
        })
    }
}


