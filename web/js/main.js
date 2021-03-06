/*price range*/

 $('#sl2').slider();

	$('.catalog').dcAccordion({
		speed: 300,
	});

	function showCart(cart) {
		$('#cart .modal-body').html(cart);		//Обращаемся к нашему модальному окну и методом html вставляем ответ (cart)
		$('#cart').modal();
	}

	function getCart() {
		// alert(123);
		$.ajax({
			url: '/cart/show',
			type: 'GET',
			success: function(res) {		//В параметре success мы будем принимать ответ
				if(!res) alert('Ошибка!');
				//console.log(res);			//Выводим в консоль ответ
				showCart(res);		//Функция showCart, которой мы передаем наш ответ (т.е. готовый вид для вставки в модальное окно)
			},
			error: function() {
				alert('Error!');
			}
		});
		return false;
	}

				//Делигирование событий (делигируем .del-item, который генерируется динамически)
	$('#cart .modal-body').on('click', '.del-item', function() {	//Обращаемся к родительскому элементу, который есть уже на странице и для него мы делегируем событие для элементов, которые появятся динамически в данном текущем элементе 
		var id = $(this).data('id');
		//console.log(id);
		$.ajax({
			url: '/cart/del-item',
			data: {id: id},
			type: 'GET',
			success: function(res) {		//В параметре success мы будем принимать ответ
				if(!res) alert('Ошибка!');
				//console.log(res);			//Выводим в консоль ответ
				showCart(res);		//Функция showCart, которой мы передаем наш ответ (т.е. готовый вид для вставки в модальное окно)
			},
			error: function() {
				alert('Error!');
			}
		});
	});

	function clearCart() {
		$.ajax({
			url: '/cart/clear',
			type: 'GET',
			success: function(res) {		//В параметре success мы будем принимать ответ
				if(!res) alert('Ошибка!');
				//console.log(res);			//Выводим в консоль ответ
				showCart(res);		//Функция showCart, которой мы передаем наш ответ (т.е. готовый вид для вставки в модальное окно)
			},
			error: function() {
				alert('Error!');
			}
		});
	}

		//------------------------ Добавление товара в корзину
	$('.add-to-cart').on('click', function(e) {
		e.preventDefault();			//Отменяет переход по ссылке при добавлении товара в корзину
		var id = $(this).data('id'),
			qty = $('#qty').val();
		$.ajax({
			url: '/cart/add',
			data: {id: id, qty: qty},
			type: 'GET',
			success: function(res) {		//В параметре success мы будем принимать ответ
				if(!res) alert('Ошибка!');
				//console.log(res);			//Выводим в консоль ответ
				showCart(res);		//Функция showCart, которой мы передаем наш ответ (т.е. готовый вид для вставки в модальное окно)
			},
			error: function() {
				alert('Error!');
			}
		});
	});
		//------------------------ Добавление товара в корзину

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});
