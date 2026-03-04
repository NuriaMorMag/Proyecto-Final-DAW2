/* CATEGORY FILTER */

const buttons = document.querySelectorAll('.category-btn'); //Busca todos los botones del menú de categorías
const photos = document.querySelectorAll('.photo');

// Cada vez que se hace clic leemos la categoría del botón ("all", "day", "night", "home")
buttons.forEach(btn => {
  btn.addEventListener('click', () => {
    const category = btn.dataset.category;

    // Marcar visualmente el botón activo 
    buttons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // recorrer todas las fotos
    photos.forEach(photo => {
      const img = photo.querySelector('img');

      // Mostrar / ocultar fotos según categoría
      if (category === 'all' || img.classList.contains(category)) {
        photo.style.display = 'block';
      } else {
        photo.style.display = 'none';
      }
    });
  });
});

/**
 * display: block = mostrarlo como siempre
 * display: none = ocultarlo totalmente
 */