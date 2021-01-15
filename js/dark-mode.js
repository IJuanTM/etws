const darkSwitch = document.getElementById("switch");
if (darkSwitch) {
  initTheme();

  darkSwitch.addEventListener("change", function (event) {
    resetTheme();
  });

  if (localStorage.getItem("switch") === "dark") {
    $("#toggle-icon").toggleClass("fa-sun");
  } else {
    $("#toggle-icon").toggleClass("fa-moon");
  }

  function initTheme() {
    const darkThemeSelected =
      localStorage.getItem("switch") !== null &&
      localStorage.getItem("switch") === "dark";
    darkSwitch.checked = darkThemeSelected;
    darkThemeSelected
      ? document.body.setAttribute("data-theme", "dark")
      : document.body.removeAttribute("data-theme");
  }

  function resetTheme() {
    if (darkSwitch.checked) {
      $("#toggle-icon").toggleClass("fa-sun");
      document.body.setAttribute("data-theme", "dark");
      localStorage.setItem("switch", "dark");
    } else {
      $("#toggle-icon").toggleClass("fa-moon");
      document.body.removeAttribute("data-theme");
      localStorage.removeItem("switch");
    }
  }
}