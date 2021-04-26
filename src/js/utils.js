
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