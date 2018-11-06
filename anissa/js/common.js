'use strict';


//config的设置是全局的
layui.config({
  base: '/wp-content/themes/anissa/js/' //假设这是你存放拓展模块的根目录
}).extend({ //设定模块别名
  canvas: 'canvas'
});

layui.use(['flow', 'jquery', 'canvas', 'form', 'element'], function () {
  var flow = layui.flow,
    form = layui.form,
    element = layui.element;
  var $ = layui.$;
  var canvas = layui.canvas;

  $.fn.extend({
    animateCss: function (animationName) {
      var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
      this.addClass('animated ' + animationName).one(animationEnd, function () {
        $(this).removeClass('animated ' + animationName);
      });
      return this;
    }
  });

  // let browserRedirect = function () {
  //   var sUserAgent = navigator.userAgent.toLowerCase();
  //   var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
  //   var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
  //   var bIsMidp = sUserAgent.match(/midp/i) == "midp";
  //   var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4 ";
  //   var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
  //   var bIsAndroid = sUserAgent.match(/android/i) == "android";
  //   var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
  //   var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
  //   if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
  //     return false;
  //   } else {
  //     return true;
  //   }
  // }
  // canvas.canvas_bg();
});


  
