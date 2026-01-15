(() => {
    const box = document.querySelector('.conversation');
    setTimeout(() => {
        box.scrollTop = box.scrollHeight;
    }, 100);
})();