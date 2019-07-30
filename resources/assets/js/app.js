
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(document).ready(function () {
		document.querySelector('#print_labels').onclick = function () {
			let orders = '';
			document.querySelectorAll('.to_print:checked').forEach(function (el) {
				orders += el.dataset.orderid + ',';
			});
			window.open("/order/label?id=" + orders, '_blank');
		};

	$('.print_all').change(function () {
		if(this.checked) {
			document.querySelectorAll('.to_print').forEach(function (el) {
				el.checked = true;
			});
		} else {
			document.querySelectorAll('.to_print:checked').forEach(function (el) {
				el.checked = false;
			});
		}
	});

	if (document.querySelector('.product')) {
		document.querySelectorAll('input[type="checkbox"]').forEach(function (el) {
			el.onchange = function(ev) {
				let request = new XMLHttpRequest();
				request.open('POST', '/api/product/toggle?id=' + ev.target.dataset.product , true);
				request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
				request.send();
			};
		});
	}
});
