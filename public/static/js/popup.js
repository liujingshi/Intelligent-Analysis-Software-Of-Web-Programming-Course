var popup = {

    layer: null,

    icon: {
        yes: 1,
        no: 2,
        ask: 3,
        lock: 4,
        cry: 5,
        laugh: 6,
        warn: 7,
        load: 16
    },

    init: function () {
        var that = this;
        layui.use('layer', function () {
            that.layer = layui.layer;
        });
    },

    msg: function (msg, icon = "none", time = 1500) {
        var layer = this.layer;
        if (icon == "none") {
            return layer.msg(msg, { time: time });
        } else {
            return layer.msg(msg, { icon: this.icon[icon], time: time });
        }
    },

    load: function (msg, time = 10000) {
        var layer = this.layer;
        return layer.msg(msg, { icon: this.icon.load, shade: 0.3, time: time })
    },

    alert: function (msg, title = "提示", icon = "none", done = function (index) { layer.close(index) }) {
        if (icon == "none") {
            return layer.alert(msg, { title: title }, done)
        } else {
            return layer.alert(msg, { icon: this.icon[icon], title: title }, done)
        }
    },

    close: function (index = "") {
        var layer = this.layer;
        if (index == "") {
            layer.closeAll()
        } else {
            layer.close(index)
        }
    },

    html: function (id, width, height, title) {
        var layer = this.layer;
        layer.open({
            type: 1,
            title: title,
            skin: 'layui-layer-rim',
            area: [width + 'px', height + 'px'],
            content: $('#' + id)
        })
    },

    ask: function (question, yes = function () { }, title = "提示", btn = ['确定', '取消'], no = function () { }) {
        var layer = this.layer;
        layer.confirm(question, {
            title: title,
            icon: this.icon.ask,
            btn: btn
        }, yes, no);
    }
}
