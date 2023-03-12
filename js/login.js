$(document).ready(function () {
  $("#login-form").validate();
  $("#login").click(function (e) {
    if (document.getElementById("login-form").checkValidity()) {
      e.preventDefault();

      $.ajax({
        url: "php/login.php",
        method: "post",
        data: $("#login-form").serialize() + "&action=login",
        // dataType: "JSON",
        success: function (res) {
          const data = JSON.parse(res);
          $("#alert").show();
          $("#result").html("Login Successful!");
          localStorage.setItem("user", JSON.stringify(data));
          window.location.href = "./profile.html";
        },
      });
    }
    return true;
  });
});
