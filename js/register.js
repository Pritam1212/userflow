$(document).ready(function () {
  $("#age").click(function () {
    if (this.value === "") {
      alert("Please enter your DOB in the above field!");
    }
  });
  $("#dob").on("change", function () {
    const dob = new Date(this.value);
    const month_diff = Date.now() - dob.getTime();
    const age_dt = new Date(month_diff);
    const year = age_dt.getUTCFullYear();
    const age = Math.abs(year - 1970);
    console.log(age);
    $("#age").val(age);
  });
  $("#register-form").validate({
    rules: {
      cpassword: {
        equalTo: "#password",
      },
    },
    messages: {
      cpassword: {
        equalTo: "Passwords do not match!",
      },
    },
  });

  $("#register").click(function (e) {
    if (document.getElementById("register-form").checkValidity()) {
      e.preventDefault();
      $.ajax({
        url: "php/register.php",
        method: "post",
        data: $("#register-form").serialize() + "&action=register",
        success: function (res) {
          $("#alert").show();
          $("#result").html(res);
        },
      });
    }
    return true;
  });
});
