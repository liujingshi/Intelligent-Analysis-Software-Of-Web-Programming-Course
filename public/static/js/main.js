
layui.use('element', function () {
    var element = layui.element;
});

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

/**
 * 打开案例
 * @param {*} id 
 */
var openPage = function (id) {
    $("#eg").attr("src", "/pages/eg" + id)
}

/**
 * 删除案例
 * @param {*} id 
 */
var delEg = function (id) {
    $.post('/api/admin/delEg', {
        id: id
    }, function () { })
}

/**
 * 添加用户
 * @param {*} username 
 * @param {*} password 
 */
var addUser = function (username, password) {
    username = $.trim(username)
    password = $.trim(password)
    if (username == "" || password == "") {
        popup.msg('用户名密码不能为空', 'no')
    } else {
        var load = popup.load('添加中...')
        $.post('/api/admin/addUser', {
            username: username,
            password: password
        }, function (res) {
            popup.close(load)
            var data = JSON.parse(res)
            if (data.state == "success") {
                layui.use('table', function () {
                    var table = layui.table
                    table.reload('userm', {
                        url: '/api/admin/getUsers'
                    })
                })
                popup.msg('添加成功', 'yes')
            } else {
                popup.msg('错误', 'cry')
            }
        })
    }
}


var addClass = function (name) {
    name = $.trim(name)
    if (name == "") {
        popup.msg('分类名不能为空', 'no')
    } else {
        var load = popup.load('添加中...')
        $.post('/api/admin/addClass', {
            name: name
        }, function (res) {
            popup.close(load)
            var data = JSON.parse(res)
            if (data.state == "success") {
                layui.use('table', function () {
                    var table = layui.table
                    table.reload('classm', {
                        url: '/api/admin/getClass'
                    })
                })
                popup.msg('添加成功', 'yes')
            } else {
                popup.msg('错误', 'cry')
            }
        })
    }
}

