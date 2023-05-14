
/**

This script handles the menu toggling and closing functionality for a responsive website.
@constant {HTMLElement} menuToggle - The HTML element representing the menu toggle button.
@constant {HTMLElement} menu - The HTML element representing the menu.
@constant {NodeList} menuItems - The collection of HTML elements representing each menu item.
@constant {HTMLElement} header - The HTML element representing the website header.
@constant {HTMLElement} firstSection - The HTML element representing the first section of the website.
@constant {HTMLElement} secondSection - The HTML element representing the second section of the website.
@constant {HTMLElement} footer - The HTML element representing the website footer.
*/
document.addEventListener('DOMContentLoaded', function () {
  const menuToggle = document.querySelector('#menu-toggle');
  const menu = document.querySelector('.menu');
  const menuItems = document.querySelectorAll('.menu li a');
  const header = document.querySelector('header');
  const firstSection = document.querySelector('#FirstSection');
  const secondSection = document.querySelector('#SecondSection');
  const footer = document.querySelector('footer');
  /**
  
  If the window width is less than or equal to 768px, the script adds event listeners to handle menu toggling
  and closing functionality.
  */
  if (window.matchMedia('(max-width: 768px)').matches) {
    // Toggle menu display on menuToggle click
    menuToggle.addEventListener('click', function () {
      menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
    });
    // Close menu on menu item click
    menuItems.forEach(function (item) {
      item.addEventListener('click', function () {
        menu.style.display = 'none';
      });
    });

    // Close menu on outside click
    document.addEventListener('click', function (event) {
      if (!menu.contains(event.target) && event.target != menuToggle) {
        menu.style.display = 'none';
      }
    });
  }
});


/**
 * Select the form element, submit button, and required inputs
 * Check if all required inputs have a value, enable the submit button, otherwise disable it
 * Add an event listener to each required input to listen for input changes and recheck validity
 */

document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('form');
  const submitBtn = document.querySelector('#submitBtn');
  const inputs = form.querySelectorAll('input[required]');
  const select = form.querySelector('select[required]');

  /**
   * Checks if all required inputs have a value, and enables/disables the submit button accordingly
   */

  function checkValidity() {
    let isValid = true;
    inputs.forEach(input => {
      if (!input.value) {
        isValid = false;
      }
    });
    if (!select.value) {
      isValid = false;
    }
    if (isValid) {
      submitBtn.removeAttribute('disabled');
    } else {
      submitBtn.setAttribute('disabled', true);
    }
  }

  // Add an event listener to each required input to listen for input changes and recheck validity

  inputs.forEach(input => {
    input.addEventListener('input', checkValidity);
  });
  select.addEventListener('change', checkValidity);
});


document.addEventListener('DOMContentLoaded', function () {
  var departmentSelect = document.getElementById("department");
  var gradeSelect = document.getElementById("grade");

  departmentSelect.addEventListener("change", function () {
    var selectedDepartment = this.value;

    while (gradeSelect.firstChild) {
      gradeSelect.removeChild(gradeSelect.firstChild);
    }

    if (selectedDepartment !== "") {
      showCustomSelect(selectedDepartment);
      gradeSelect.style.display = "block";
    } else {
      gradeSelect.style.display = "none";
    }
  });

  function showCustomSelect(selectedDepartment) {
    var options = [];

    if (selectedDepartment === "Mathematics and Informatics") {
      options = ["L1", "L2"];
    } else if (selectedDepartment === "Informatique Fondamentale et ses Applications") {
      options = ["TI", "SCI", "M1 STIC", "M2 STIC", "M1 RSD", "M2 RSD"];
    } else if (selectedDepartment === "Technologies des Logiciels et des Systèmes d'Information") {
      options = ["GL", "SI", "M1 GL", "M2 SITW", "M1 GL", "M2 SITW"];
    }

    // Clear existing options
    gradeSelect.innerHTML = "";


