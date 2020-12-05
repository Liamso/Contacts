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

cleanEmptyNumbers = function (e) {
    var number = document.getElementById('newNumber');
    var is_primary = document.getElementById('newPrimary');

    if (number.value === '' && is_primary.getAttribute('checked') === null) {
        number.disabled = true;
        is_primary.disabled = true;
    }
}

destroyContactNumber = function (id) {
    document.getElementById('destroyContactNumberInput').value = id;
    document.getElementById('destroyContactNumberForm').submit();
}