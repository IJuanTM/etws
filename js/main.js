// Define url
const baseUrl = window.location.origin + '/';
const urlArr = window.location.pathname.split('/');

// Check if IE
if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) {
  $("body").load("../../view/parts/errors/unsupported.phtml");
}

// Show and hide password
$(document).on('click', '.toggle-password', function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  const passwordInput = $(":text, :password")
  passwordInput.attr('type') === 'password' ? passwordInput.attr('type', 'text') : passwordInput.attr('type', 'password');
});

// On page load
$(document).ready(function () {

  // Get day and translate to mon, tue, wed...
  let day_id
  switch (new Date().getDay()) {
    case 0:
      day_id = "sun";
      break;
    case 1:
      day_id = "mon";
      break;
    case 2:
      day_id = "tue";
      break;
    case 3:
      day_id = "wed";
      break;
    case 4:
      day_id = "thu";
      break;
    case 5:
      day_id = "fri";
      break;
    case 6:
      day_id = "sat";
  }

  // Ajax code every minute to check if day is changed
  function day() {
    $.ajax({
      success: function (data) {
        $(day_id).html(data);
        window.setTimeout(day, 60000);
      }
    });
  }

  // Run ajax code only on dashboard page
  if (location.href === baseUrl + '/dashboard') day();

  // Add current class to the right day
  const current = document.getElementById(day_id);
  if (current) current.className += " current";

  // // Ajax code to automatically update kwh
  // function kwh() {
  //   $.ajax({
  //     url: baseUrl + 'view/parts/ajax/display.php',
  //     success: function (data) {
  //       $("#display").html(data);
  //       console.log(data);
  //       window.setTimeout(kwh, 1000);
  //     }
  //   });
  // }
  //
  // console.log(kwh());
  //
  // // Run ajax code only on dashboard page
  // if (location.href === baseUrl + '/dashboard') kwh();
});

// Load icon
document.onreadystatechange = function () {
  $("body").css("overflow", "hidden");
  const state = document.readyState;
  if (state === "interactive") {
    document.getElementById("content").style.visibility = "hidden";
  } else if (state === "complete") {
    setTimeout(function () {
      $("body").css("overflow", "visible");
      document.getElementById("interactive");
      document.getElementById("load").style.visibility = "hidden";
      document.getElementById("content").style.visibility = "visible";
    }, 100);
  }
};