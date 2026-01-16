(() => {
    let containersPhotos = document.querySelectorAll('.photo-container');
    let croix = document.querySelectorAll('.croix');

    containersPhotos.forEach(container => {
        if (container.dataset.init) return;
        container.dataset.init = "true";

        container.addEventListener('click', () => {
            container.classList.add('photo-zoom');
        });
    });

    croix.forEach(c => {
        if (c.dataset.init) return;
        c.dataset.init = "true";

        c.addEventListener('click', (e) => {
            e.stopPropagation();
            let container = e.target.closest('.photo-container');
            if (container) {
                container.classList.remove('photo-zoom');
            }
        });
    });
})();