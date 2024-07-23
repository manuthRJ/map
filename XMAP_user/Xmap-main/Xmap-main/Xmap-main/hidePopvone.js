//this is for hide the ads popup on user.php , and also refresh relevant that div which locate on user.php, box per 10 second.
document.addEventListener('DOMContentLoaded', function() {
    var pop = document.getElementById('popmain');
    if (pop) {
        pop.style.display = 'none';
    }
});
