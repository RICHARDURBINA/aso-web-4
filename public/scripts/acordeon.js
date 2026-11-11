const collapseElementList = Array.from(document.querySelectorAll('.card-collapsible'));

  // Collapsible card
  // --------------------------------------------------------------------
  collapseElementList.forEach(function (collapseElement) {
    collapseElement.addEventListener('click', function (event) {
      event.preventDefault();
      // Collapse the element
      new bootstrap.Collapse(collapseElement.closest('.card').querySelector('.collapse'));
      // Toggle collapsed class in .card-header element
      collapseElement.closest('.card-header').classList.toggle('collapsed');
      // Toggle class ri-arrow-down-s-line &  ri-arrow-up-s-line
      Helpers._toggleClass(collapseElement.firstElementChild, 'ri-arrow-down-s-line', 'ri-arrow-up-s-line');
    });
  });