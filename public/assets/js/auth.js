/**
 * Select the form element, submit button, and required inputs
 * Check if all required inputs have a value, enable the submit button, otherwise disable it
 * Add an event listener to each required input to listen for input changes and recheck validity
 */

const form = document.querySelector('form');
const submitBtn = document.querySelector('#submitBtn');
const inputs = form.querySelectorAll('input[required]');

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

  if (isValid) {
    submitBtn.removeAttribute('disabled');
  } else {
    submitBtn.setAttribute('disabled', true);
  }
}

// Add an event listener to each required input to listen for input changes and recheck validity
if(inputs){
inputs.forEach(input => {
  input.addEventListener('input', checkValidity);
});}
