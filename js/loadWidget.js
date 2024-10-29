function bb_loadWidget(w, d, s, o, f, js, fjs) {
	if (w[o]) return;
	w['BB-Widget'] = o; w[o] = w[o] || function () { (w[o].q = w[o].q || []).push(arguments) };
	js = d.createElement(s), fjs = d.getElementsByTagName(s)[0];
	js.id = o; js.src = f; js.async = 1; fjs.parentNode.insertBefore(js, fjs);
}

bb_loadWidget(window, document, 'script', 'w1', 'https://bed-booking.com/widget/widget.js');
