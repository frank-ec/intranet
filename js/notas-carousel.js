document.addEventListener('DOMContentLoaded', function () {
	var contenedor = document.getElementById('notas-carousel');
	if (!contenedor) {
		return;
	}

	var items = contenedor.querySelectorAll('.nota-item');
	if (items.length <= 1) {
		return;
	}

	var indice = 0;
	var intervalo = setInterval(avanzar, 8000);

	function avanzar() {
		items[indice].classList.remove('activa');
		indice = (indice + 1) % items.length;
		items[indice].classList.add('activa');
	}

	contenedor.addEventListener('mouseenter', function () {
		clearInterval(intervalo);
	});
	contenedor.addEventListener('mouseleave', function () {
		intervalo = setInterval(avanzar, 8000);
	});
});
