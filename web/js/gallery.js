/* CATEGORY FILTER */

// Get all the category buttons in the category menu
const buttons = document.querySelectorAll('.category-btn'); // finds all elements with the class .category-btn

const photos = document.querySelectorAll('.photo');

// When this button is clicked, run this function
buttons.forEach(btn => {
  btn.addEventListener('click', () => {
    const category = btn.dataset.category; // This reads the value of data-category from the button

    // Visually highlight the active button 
    buttons.forEach(b => b.classList.remove('active')); // First, it removes the active class from all buttons
    btn.classList.add('active'); // Then, it adds the active class only to the button that was clicked (btn)

    // Go through all photos
    // For each photo box it finds the <img> inside 
    photos.forEach(photo => {
      const img = photo.querySelector('img');

      /**
       * Show or hide photos depending on the selected category
       * If the selected category is "all" 
       * or if the image has a class that matches the category
       * shows or hides by changing the CSS 
       * */
      if (category === 'all' || img.classList.contains(category)) {
        photo.style.display = 'block'; // show the photo
      } else {
        photo.style.display = 'none'; // hide the photo
      }
    });
  });
});

/**
 * display: block = show the element normally
 * display: none = hide the element completely
 */