function setCookie(name, value) {
    var argv = setCookie.arguments;
    var argc = setCookie.arguments.length;
    var expires = (argc > 2) ? argv[2] : null;
    if (expires != null) {
        var LargeExpDate = new Date();
        LargeExpDate.setTime(LargeExpDate.getTime() + (expires * 1000 * 3600 * 24));
    }
    document.cookie = name + "=" + escape(value) + ((expires == null) ? "" : ("; expires=" + LargeExpDate.toGMTString()));
}

function getCookie(Name) {
    var search = Name + "="
    if (document.cookie.length > 0) {
        offset = document.cookie.indexOf(search)
        if (offset != -1) {
            offset += search.length
            end = document.cookie.indexOf(";", offset)
            if (end == -1) end = document.cookie.length
            return unescape(document.cookie.substring(offset, end))
        } else return ""
    }
}

function ctrlClass(opts) {
    if (!opts.ele || !opts.c) return false;
    // console.log(opts.c)
    var c = null;
    typeof (opts.c) === 'string' ?
    c = opts.c.trim().replace(/\s+/g, ' ').split(' '):
        c = opts.c; //修复不规范传参

    return opts.fun({
        ele: opts.ele,
        c: c
    });
    opts.ele = null;
}

/**
 * hasClass
 * @param (element, 'c1 c2 c3 c4 c5')
 */
function hasClass(ele, c) {
    return ctrlClass({
        ele: ele,
        c: c,
        fun: function (opts) {
            return opts.c.every(function (v) {
                return !!opts.ele.classList.contains(v);
            });
        }
    });
}

/**
 * addClass
 * @param (element, 'c1 c2 c3 c4 c5')
 */
function addClass(ele, c) {
    return ctrlClass({
        ele: ele,
        c: c,
        fun: function (opts) {
            var ele = opts.ele,
                c = opts.c;
            c.forEach(function (v) {
                if (!hasClass(ele, v)) {
                    ele.classList.add(v);
                }
            });
        }
    })
}

/**
 * removeClass
 * @param (element, 'c1 c2 c3')
 */
function removeClass(ele, c) {
    ctrlClass({
        ele: ele,
        c: c,
        fun: function (opts) {
            var ele = opts.ele,
                c = opts.c;
            c.forEach(function (v) {
                // TODO 是否有必要判断 hasClass
                // if (!hasClass(ele, v)) {
                ele.classList.remove(v);
                // }
            });
        }
    });
}


/**
 * toggleClass
 * @param (element, 'c1 c2 c3')
 */
function toggleClass(ele, c) {
    ctrlClass({
        ele: ele,
        c: c,
        fun: function (opts) {
            var ele = opts.ele,
                c = opts.c;
            c.forEach(function (v) {
                ele.classList.toggle(v);
            })
        }
    })
}

function hover(ele, over, out) {
    ele.addEventListener('mouseover', over, false);
    ele.addEventListener('mouseout', out, false);
}