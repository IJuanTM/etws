// Define url
const baseUrl = window.location.origin + '/';

// Check if IE
if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) $("body").load("../../view/parts/errors/unsupported.phtml");

// ------------------------------------------------------------------------------------------------

// Show and hide password
$(document).on('click', '.toggle-password', function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  const passwordInput = $(":text, :password");
  passwordInput.attr('type') === 'password' ? passwordInput.attr('type', 'text') : passwordInput.attr('type', 'password');
});

// ------------------------------------------------------------------------------------------------

// Ajax code for current time
function time() {
  let hours = new Date().getHours();
  if (hours < 10) hours = "0" + hours;

  let minutes = new Date().getMinutes();
  if (minutes < 10) minutes = "0" + minutes;

  let seconds = new Date().getSeconds();
  if (seconds < 10) seconds = "0" + seconds;

  $.ajax({
    success: function () {
      const time = hours + ":" + minutes + ":" + seconds;
      console.log("Synced: " + time);
    }
  });
}

// Ajax code every minute to check if day is changed
function day() {
  let day_id;
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
      break;
  }

  $.ajax({
    success: function () {
      const current = document.getElementById(day_id);
      if (current) current.className += " current";
    }
  });
}

// Ajax code to automatically update display every 10 seconds
function display() {
  let text = ".reload-text";
  $.ajax({
    success: function () {
      spin();
      setTimeout(function () {
        $("#display").load(" #display > *");
        day();
        time();
      }, 2000);
      $(text).css("width", "100%");
      $(text).css("margin-right", "1vmin");
      $(text).css("opacity", "100%");
      setTimeout(function () {
        $(text).css("width", "0");
        $(text).css("margin-right", "0");
        $(text).css("opacity", "50%");
      }, 1000);
    }
  });
}

// Auto sync every 60 seconds
function sync() {
  $.ajax({
    success: function () {
      display();
      setTimeout(sync, 60000);
    }
  });
}

// Spin icon
function spin() {
  $.ajax({
    success: function () {
      $(".reload").addClass(" spin");
    }
  });
}

// Manual reload page
$(document).on('click', '#reload', display);

// Run ajax code only on dashboard page
if (location.href === baseUrl + 'dashboard/') {
  day();
  setTimeout(sync, 58000);
}

// ------------------------------------------------------------------------------------------------

// Load icon
$(document).on('readystatechange', function () {
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
});