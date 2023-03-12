$(document).ready(function () {
  $.ajax({
    url: "php/profile.php",
    method: "get",
    success: function (res) {
      if ($.trim(res) === "Authenticated!") {
        console.log("Authenticated");
      } else {
        console.log("nope");
        window.location.replace("./login.html");
      }
    },
  });

  const user = JSON.parse(localStorage.getItem("user"));

  //   console.log(user._id["$oid"]);

  $("#fname").html(user.firstName);
  $("#lname").html(user.lastName);
  $("#email").html(user.email);
  $("#mobile").html(user.mobile);
  $("#address").html(user.address);
  $("#dob").html(user.dob);
  $("#age").html(user.age);
  $("h2").text("Hi, " + user.firstName + "! ");
  $("h2").append('<i id="edit" class="fa fa-pencil-square-o"></i>');

  $("#logout").click(function () {
    localStorage.removeItem("user");
    window.location.href = "./login.html";
  });
});
