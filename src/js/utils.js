
// 转换 json - tree
function transData(a, idStr, pidStr, chindrenStr) {
    var r = [];
    var hash = {};
    var id = idStr;
    var pid = pidStr;
    var children = chindrenStr;
    var i = 0;
    var j = 0;
    var len = a.length;
    for (; i < len; i++) {
        hash[a[i][id]] = a[i];
    }
    for (; j < len; j++) {
        var aVal = a[j];
        aVal.level = 1;
        var hashVP = hash[aVal[pid]];
        if (hashVP) {
            aVal.level++
                !hashVP[children] && (hashVP[children] = []);
            hashVP[children].push(aVal);
        } else {
            r.push(aVal);
        }
    }
    return r;
 }

 function setOpacity(ele, opacity) {
    if (ele.style.opacity != undefined) {
        ///兼容FF和GG和新版本IE
        ele.style.opacity = opacity / 100;

    } else {
        ///兼容老版本ie
        ele.style.filter = "alpha(opacity=" + opacity + ")";
    }
}

function fadeout(ele, opacity, speed) {
    if (ele) {
        var v = ele.style.filter.replace("alpha(opacity=", "").replace(")", "") || ele.style.opacity || 100;
        v < 1 && (v = v * 100);
        var count = speed / 1000;
        var avg = (100 - opacity) / count;
        var timer = null;
        timer = setInterval(function() {
            if (v - avg > opacity) {
                v -= avg;
                setOpacity(ele, v);
            } else {
                clearInterval(timer);
            }
        }, 500);
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
 
 