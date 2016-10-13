window.onload = function() {
	var opts = document.getElementById("productcategory-pid");
	var value = _opts.id.pid;// 这个值就是你获取的值;

	if (value != "") {
		for (var i = 0; i < opts.options.length; i++) {
			if (value == opts.options[i].value) {
				opts.options[i].selected = 'selected';
				break;
			}
		}
	}
}