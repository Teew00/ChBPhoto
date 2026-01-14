document.addEventListener("turbo:load", () => {
    let containersPhotos = document.querySelectorAll('.photo-container');
    let croix = document.querySelectorAll('.croix');

    containersPhotos.forEach(container => {
        container.addEventListener('click', () => {
            container.classList.add('photo-zoom');
        })
    })

    croix.forEach(c => {
        c.addEventListener('click', (e) => {
            e.stopPropagation();

            let container = e.target.closest('.photo-container');
            if (container) {
                container.classList.remove('photo-zoom');
            }
        })
    })
});
