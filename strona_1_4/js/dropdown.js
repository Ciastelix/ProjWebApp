var dropdownButton = document.querySelector(".dropdown");
var dropdownContent = document.querySelector(".dropdown-content");

// Toggle the dropdown when the button is clicked
dropdownButton.addEventListener("click", function () {
  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
  }
});

// Close the dropdown if the user clicks outside of it
window.addEventListener("click", function (event) {
  if (!event.target.matches(".dropbtn")) {
    dropdownContent.style.display = "none";
  }
});
