!function(r,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):r.dayjs_plugin_relativeTime=t()}(this,function(){"use strict";return function(r,t,e){var n=t.prototype;e.en.relativeTime={future:"in %s",past:"%s ago",s:"a few seconds",m:"a minute",mm:"%d minutes",h:"an hour",hh:"%d hours",d:"a day",dd:"%d days",M:"a month",MM:"%d months",y:"a year",yy:"%d years"};var o=function(r,t,n,o){for(var d,i,u,a=n.$locale().relativeTime,f=[{l:"s",r:44,d:"second"},{l:"m",r:89},{l:"mm",r:44,d:"minute"},{l:"h",r:89},{l:"hh",r:21,d:"hour"},{l:"d",r:35},{l:"dd",r:25,d:"day"},{l:"M",r:45},{l:"MM",r:10,d:"month"},{l:"y",r:17},{l:"yy",d:"year"}],s=f.length,l=0;l<s;l+=1){var h=f[l];h.d&&(d=o?e(r).diff(n,h.d,!0):n.diff(r,h.d,!0));var m=Math.round(Math.abs(d));if(u=d>0,m<=h.r||!h.r){1===m&&l>0&&(h=f[l-1]);var c=a[h.l];i="string"==typeof c?c.replace("%d",m):c(m,t,h.l,u);break}}return t?i:(u?a.future:a.past).replace("%s",i)};n.to=function(r,t){return o(r,t,this,!0)},n.from=function(r,t){return o(r,t,this)};var d=function(r){return r.$u?e.utc():e()};n.toNow=function(r){return this.to(d(this),r)},n.fromNow=function(r){return this.from(d(this),r)}}});