
/**
 * 弹出层
 */
var popup = {

    layer: null,

    init: function () {
        var that = this
        layui.use('layer', function () {
            that.layer = layui.layer
        })
    },

    load: function () {
        return this.layer.msg("验证中...", { icon: 16, shade: 0.3, time: 10000 })
    },

    msg: function (msg, ico = 'none', time = 1500) {
        var icon = {
            yes: 1,
            no: 2,
            ask: 3,
            load: 4,
            cry: 5,
            laugh: 6,
            notice: 7
        }
        if (ico == 'none') {
            this.layer.msg(msg, { time: time })
        } else {
            this.layer.msg(msg, { icon: icon[ico], time: time })
        }
    },

    close: function (item) {
        this.layer.close(item)
    },

    closeAll: function () {
        this.layer.closeAll()
    }
}

popup.init() // 初始化弹出层

/**
 * 管理员登录验证
 * @param {*} username 
 * @param {*} password 
 */
var adminLogin = function (username, password) {
    username = $.trim(username)
    password = $.trim(password)
    if (username == "" || password == "") {
        popup.msg('用户名或密码不能为空', 'no')
    } else {
        var load = popup.load()
        $.post('/api/admin/login', {
            username: username,
            password: password
        }, function (res) {
            popup.close(load)
            var data = JSON.parse(res)
            if (data.state == "success") {
                document.location.href = "/admin"
            } else {
                popup.msg('用户名或密码错误', 'cry')
            }
        })
    }
}


