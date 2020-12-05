toggleMobile = function () {
    var el = document.getElementById('mobileNav');
    el.classList.toggle('hidden');
}

dismissNotification = function () {
    var el = document.getElementById('notification');
    el.classList.add('opacity-0');
    setTimeout(() => { 
        el.classList.add('h-0'); 
        el.remove(); 
    }, 500);
}
