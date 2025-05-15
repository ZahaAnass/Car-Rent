function filterCars(selectedCategory) {
    const categories = document.querySelectorAll('.category-section');
    categories.forEach(category => {
        if (category.id === selectedCategory) {
            category.style.display = 'block';
        } else {
            category.style.display = 'none';
        }
    })
    if(selectedCategory === 'All') {
        categories.forEach(category => {
            category.style.display = 'block';
        })
    }
}
