var loading = false;
Vue.http.interceptors.push(function (request, next) {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;
    layer.load();
    next(function (response) {
        if (!response.ok) {
            layer.alert('异常：' + JSON.stringify(response), {icon: 5});
        }
        layer.closeAll('loading');
        return response
    })
});


Vue.validator('tel', function (val) {
    return /^[0-9]{11}$/.test(val)
});

Vue.validator('passw', function (val) {
    return /^(\w){6,20}$/.test(val)
});

//JSON过滤转换
function jsonFilter(_str) {
    var arrEntities = {'lt': '<', 'gt': '>', 'nbsp': ' ', 'amp': '&', 'quot': '"'};
    return JSON.parse(_str.replace(/&(lt|gt|nbsp|amp|quot);/ig, function (all, t) {
        return arrEntities[t];
    }));
}

//成功操作提醒
function msg(msg) {
    layer.msg(msg, {offset: '2px', time: 2000});
}

function loading(msg) {
    layer.msg(msg, {
        icon: 16
        , shade: 0.01
    });
}
function openUrl(url, title, w, h) {
    if (title == null) {
        title = false;
    }
    if (w == null) {
        w = 600;
    }
    if (h == null) {
        h = 400;
    }
    layer.open({
        type: 2,
        title: title,
        area: [w + 'px', h + 'px'],
        //shade: 0.4,
        closeBtn: 1,
        shadeClose: false,
        shade: false,
        maxmin: true, //开启最大化最小化按钮
        content: url
    });
}

function open(_obj, w, h) {
    layer.open({
        type: 1,
        area: ['600px', '360px'],
        shadeClose: true, //点击遮罩关闭
        content: $(_obj)
    });
}
