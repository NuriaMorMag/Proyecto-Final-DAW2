/* CATEGORY FILTER */

// Find all the buttons in the category menu
const buttons = document.querySelectorAll('.category-btn'); 

const photos = document.querySelectorAll('.photo');

// Every time a button is clicked, categoty is read
buttons.forEach(btn => {
  btn.addEventListener('click', () => {
    const category = btn.dataset.category;

    // Visually highlight the active button 
    buttons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // Go through all photos
    photos.forEach(photo => {
      const img = photo.querySelector('img');

      // Show or hide photos depending on the selected category
      if (category === 'all' || img.classList.contains(category)) {
        photo.style.display = 'block';
      } else {
        photo.style.display = 'none';
      }
    });
  });
});

/**
 * display: block = show the element normally
 * display: none = hide the element completely
 */