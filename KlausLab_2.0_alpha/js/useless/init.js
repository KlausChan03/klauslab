! function() {
	var pageWid = 720;

	function a() {
		document.documentElement.style.fontSize = document.documentElement.clientWidth / pageWid * 10 / 16 * 1000 + "%"
	}
	var b = null;
	window.addEventListener("resize", function() {
		clearTimeout(b);
		b = setTimeout(a, 300)
	}, !1);
	a()
}(window);