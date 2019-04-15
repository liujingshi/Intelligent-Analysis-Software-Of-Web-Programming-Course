
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
    eg = "eg" + id
    $("#eg").attr("src", "/pages/eg" + id)
    analyze("eg" + id)
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

/**
 * 添加分类
 * @param {*} name 
 */
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

/**
 * 添加案例
 * @param {*} iclass 
 * @param {*} name 
 */
var addEg = function (iclass, name) {
    iclass = $.trim(iclass)
    name = $.trim(name)
    if (name == "") {
        popup.msg('案例名不能为空', 'no')
    } else {
        var load = popup.load('添加中...')
        $.post('/api/admin/addEg', {
            iclass: iclass,
            name: name
        }, function (res) {
            popup.close(load)
            var data = JSON.parse(res)
            if (data.state == "success") {
                layui.use('table', function () {
                    var table = layui.table
                    table.reload('egm', {
                        url: '/api/admin/getEgs'
                    })
                })
                popup.msg('添加成功', 'yes')
            } else {
                popup.msg('错误', 'cry')
            }
        })
    }
}


var delEgDir = function (eg, dir) {
    $.post('/api/admin/delEgDir', {
        eg: eg,
        dir: dir
    }, function () { })
}

var delFile = function (eg, dir) {
    $.post('/api/admin/delFile', {
        eg: eg,
        dir: dir
    }, function () { })
}

var egData = null

var analyze = function (eg) {
    $.post('/api/index/analyze', {
        eg: eg
    }, function (res) {
        var data = JSON.parse(res)
        egData = data
        setStaticFiles()
        code_all.setValue(egData.all);
        code_html.setValue(egData.html);
        code_css.setValue(egData.css);
        code_js.setValue(egData.js);
    })
}

var change = function (eg, name, text) {
    var load = popup.load("修改中...")
    $.post('/api/index/change', {
        eg: eg,
        name: name,
        text: text
    }, function (res) {
        popup.close(load)
        $("#old").attr("src", "/pages/temp")
        $("#new").attr("src", "/pages/" + eg)
        $("#eg").attr("src", "/pages/" + eg)
        popup.html('change-div', 1600, 600, "修改前后对比")
    })
}

