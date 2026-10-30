// Show toasts queued by the server.
document.querySelectorAll('.site-toast').forEach(function (el) {
    new bootstrap.Toast(el, { delay: 5000 }).show();
});

// Product page: clicking a thumbnail swaps the main image.
(function () {
    var main = document.getElementById('mainImg');
    var thumbs = document.querySelectorAll('.small-img');
    if (!main || !thumbs.length) return;
    thumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            main.src = thumb.src;
            thumbs.forEach(function (t) { t.classList.remove('selected'); });
            thumb.classList.add('selected');
        });
    });
})();

// Ask before destructive actions.
document.querySelectorAll('[data-confirm]').forEach(function (el) {
    el.addEventListener('click', function (event) {
        if (!window.confirm(el.getAttribute('data-confirm'))) event.preventDefault();
    });
});
