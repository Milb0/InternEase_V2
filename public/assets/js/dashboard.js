// TOOLTIP
const viewDetailsButtons = document.querySelectorAll('.viewDetailsButton');
const editDetailsButtons = document.querySelectorAll('.editDetailsButton');
const deleteInternshipButtons = document.querySelectorAll('.deleteInternshipButton');
const attendanceButtons = document.querySelectorAll('.attendanceButton');
const profileEditButtons = document.querySelectorAll('.profileEditButtons');

function attachTooltipEvents(buttons) {
  buttons.forEach(button => {
    const tooltip = button.querySelector('span');

    // Hide the tooltip span initially
    tooltip.style.display = 'none';

    // Show the tooltip span on mouse enter
    button.addEventListener('mouseenter', () => {
      tooltip.style.display = 'block';
    });

    // Hide the tooltip span on mouse leave
    button.addEventListener('mouseleave', () => {
      tooltip.style.display = 'none';
    });
  });
}
if(viewDetailsButtons){
  attachTooltipEvents(viewDetailsButtons);
}
if (editDetailsButtons) {
  attachTooltipEvents(editDetailsButtons);
}
if (deleteInternshipButtons) {
attachTooltipEvents(deleteInternshipButtons);
}
if(attendanceButtons){
  attachTooltipEvents(attendanceButtons);
}
if(profileEditButtons){
  attachTooltipEvents(profileEditButtons);
}

// SIDE BAR HAMBURGER MENU
function closeSidebar() {
  var sidebar = document.getElementById("sidebar");
  if (sidebar) {
    sidebar.classList.add("-translate-x-full");
  }
}
function toggleSidebar() {
  var sidebarButton = document.querySelector("[data-drawer-toggle='logo-sidebar']");
  var sidebar = document.getElementById("sidebar");

  if (sidebarButton && sidebar) {
    sidebarButton.addEventListener("click", function (event) {
      event.stopPropagation(); // Prevent the click event from bubbling up to the document
      sidebar.classList.toggle("-translate-x-full");
    });

    document.addEventListener("click", function (event) {
      var isSidebarClicked = sidebar.contains(event.target);
      var isSidebarButtonClicked = sidebarButton.contains(event.target);

      if (!isSidebarClicked && !isSidebarButtonClicked) {
        closeSidebar();
      }
    });
  }
}
document.addEventListener("DOMContentLoaded", function () {
  toggleSidebar();
});

// PROFILE MENU
function toggleMenu() {
  const menu = document.getElementById('dropdown-user');
  const toggleButton = document.querySelector('[data-dropdown-toggle="dropdown-user"]');

  if (menu && toggleButton) {
    // Toggle the visibility of the menu
    menu.classList.toggle('hidden');

    // Add event listener to the document to hide the menu when clicking outside of it
    document.addEventListener('click', function (event) {
      const isClickInsideMenu = menu.contains(event.target);
      const isClickOnButton = toggleButton.contains(event.target);

      if (!isClickInsideMenu && !isClickOnButton) {
        menu.classList.add('hidden');
      }
    });

    // Add event listeners to the dropdown items to hide the menu when clicked
    const dropdownItems = document.querySelectorAll('#dropdown-user [role="menuitem"]');
    dropdownItems.forEach(function (item) {
      item.addEventListener('click', function () {
        menu.classList.add('hidden');
      });
    });
  }
}
//SIGN OUT MODAL
function toggleSignOutModal() {
  var modal = document.getElementById('modal');
  modal.classList.toggle('hidden');
}

function closeSignOutModal() {
  var modal = document.getElementById('modal');
  modal.classList.add('hidden');
}
document.addEventListener("DOMContentLoaded", function () {
  closeSignOutModal();
});

// CONFIRMATION MODAL
function toggleConfirmationModal() {
  var modal = document.getElementById('confirmationModal');
  modal.classList.toggle('hidden');
}

function closeConfirmationModal() {
  var modal = document.getElementById('confirmationModal');
  modal.classList.add('hidden');
}
document.addEventListener("DOMContentLoaded", function () {
  closeConfirmationModal();
});
// REFUSAL MODAL
function toggleRefusalModal() {
  var modal = document.getElementById('refusalModal');
  modal.classList.toggle('hidden');
}

function closeRefusalModal() {
  var modal = document.getElementById('refusalModal');
  modal.classList.add('hidden');
}
document.addEventListener("DOMContentLoaded", function () {
  closeRefusalModal();
});
// FEEDBACK MODAL
function toggleFeedbackModal() {
  var feedbackModal = document.getElementById('feedbackModal');
  feedbackModal.classList.toggle('hidden');
}

function closeFeedbackModal() {
  var feedbackModal = document.getElementById('feedbackModal');
  feedbackModal.classList.add('hidden');
}
document.addEventListener("DOMContentLoaded", function () {
  closeFeedbackModal();
});

//Alert Message
function closeAlertDialogue() {
  const closeAlertButton = document.querySelector('#alert-close-button');
  const internshipAlert = document.querySelector('#alert-additional-content-3');

  if (closeAlertButton && internshipAlert) {
    closeAlertButton.addEventListener('click', function () {
      internshipAlert.classList.add('hidden');
    });
  }
}

// DETAILS MODAL
function toggleDetailsModal() {
  // Get the modal element
  const detailsModal = document.getElementById('details-modal');

  if (detailsModal) {
    // Check if the modal is hidden
    const isHidden = detailsModal.classList.contains('hidden');

    if (isHidden) {
      // Show the modal
      detailsModal.classList.remove('hidden');

      // Add event listener to the close button inside the modal
      const closeButton = detailsModal.querySelector('[data-modal-hide]');
      if (closeButton) {
        closeButton.addEventListener('click', function () {
          // Hide the modal
          detailsModal.classList.add('hidden');
        });
      }

      // Add event listener to the document to hide the modal when clicking outside of it
      document.addEventListener('click', function (event) {
        if (event.target === detailsModal) {
          // Hide the modal when clicking on the background
          detailsModal.classList.add('hidden');
        }
      });
    } else {
      // Hide the modal if it was already shown
      detailsModal.classList.add('hidden');
    }
  }
}

const descriptionInput = document.getElementById('description');
const descriptionCounter = document.getElementById('description-counter');
const messageInput = document.getElementById('message');
const messageCounter = document.getElementById('message-counter');
const customReasonInput = document.getElementById('customReason');
const customReasonCounter = document.getElementById('customReason-counter');

let limit;

if (descriptionInput && descriptionCounter) {
  limit = 1000;
  descriptionInput.addEventListener('input', updateCharacterCounter.bind(descriptionInput, descriptionCounter, limit));
}
if (messageInput && messageCounter) {
  limit = 2000;
  messageInput.addEventListener('input', updateCharacterCounter.bind(messageInput, messageCounter, limit));
}
if (customReasonInput && customReasonCounter) {
  limit = 500;
  customReasonInput.addEventListener('input', updateCharacterCounter.bind(customReasonInput, customReasonCounter, limit));
}

function updateCharacterCounter(counterElement, limit) {
  const maxLength = limit;
  let currentLength = this.value.length;

  if (currentLength > maxLength) {
    this.value = this.value.substring(0, maxLength);
    currentLength = maxLength;
  }

  counterElement.textContent = `${currentLength}/${maxLength} characters`;
}


// GRAD DYNAMIC SELECT 
var departmentSelect = document.getElementById("department");
var gradeSelect = document.getElementById("grade");
var gradp = document.getElementById("tempgradp");

departmentSelect.addEventListener("change", function () {
  var selectedDepartment = this.value;

  while (gradeSelect.firstChild) {
    gradeSelect.removeChild(gradeSelect.firstChild);
  }

  if (selectedDepartment !== "") {
    gradp.classList.add('hidden');
    showCustomSelect(selectedDepartment);
    gradeSelect.style.display = "block";
  } else {
    gradeSelect.style.display = "none";
  }
});

function showCustomSelect(selectedDepartment) {
  var options = [];

  if (selectedDepartment === "Fundamental Computer Science and its Applications") {
    options = ["L3 TI", "L3 SCI", "M2 STIC", "M2 RSD"];
  } else if (selectedDepartment === "Software and Information Systems Technologies") {
    options = ["L3 GL", "L3 SI", "M2 SITW", "M2 GL"];
  }

  // Clear existing options
  gradeSelect.innerHTML = "";

  // Add "Select Grade" option
  var selectOption = document.createElement("option");
  selectOption.value = "";
  selectOption.disabled = true;
  selectOption.selected = true;
  selectOption.text = "Select Grade";
  gradeSelect.appendChild(selectOption);

  // Add custom options
  options.forEach(function (optionValue) {
    var option = document.createElement("option");
    option.value = optionValue;
    option.text = optionValue;
    gradeSelect.appendChild(option);
  });
}

// PASSWORD VISIBILITY 
function togglePasswordVisibility(inputId) {
  var input = document.getElementById(inputId);
  var icon = document.getElementById(inputId + '-icon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}