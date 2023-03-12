$(document).ready(function () {
  const user = JSON.parse(localStorage.getItem("user"));

  $("#edit").click(function () {
    $("h2").text("Update Profile! ");

    $("#fnameu").val(user.firstName);
    $("#lnameu").val(user.lastName);
    $("#emailu").val(user.email);
    $("#mobileu").val(user.mobile);
    $("#addressu").val(user.address);
    $("#dobu").val(user.dob);
    $("#ageu").val(user.age);
    $("h2").val("Update Profile! ");
    $("#table").hide();
    $("#update").show();
  });

  $("#goback").on("click", function (e) {
    e.preventDefault();
    $("h2").text("Hi, " + user.firstName + "! ");
    $("#update").hide();
    $("#table").show();
  });

  $("#age").click(function () {
    if (this.value === "") {
      alert("Please enter your DOB in the above field!");
    }
  });
  $("#dobu").on("change", function () {
    const dob = new Date(this.value);
    const month_diff = Date.now() - dob.getTime();
    const age_dt = new Date(month_diff);
    const year = age_dt.getUTCFullYear();
    const age = Math.abs(year - 1970);
    console.log(age);
    $("#ageu").val(age);
  });

  //update
  $("#update-form").validate();

  $("#save").click(function (e) {
    if (document.getElementById("update-form").checkValidity()) {
      e.preventDefault();
      $.ajax({
        url: "php/update.php",
        method: "post",
        data:
          $("#update-form").serialize() +
          "&action=update&oid=" +
          user._id["$oid"],
        success: function (res) {
          $("#alert").show();
          $("#result").html(res);
        },
      });
      const updatedUser = {
        firstName: $("#fnameu").val(),
        lastName: $("#lnameu").val(),
        email: $("#emailu").val(),
        mobile: $("#mobileu").val(),
        address: $("#addressu").val(),
        dob: $("#dobu").val(),
        age: $("#ageu").val(),
        _id: {
          $oid: user._id["$oid"],
        },
      };
      console.log(updatedUser);

      localStorage.setItem("user", JSON.stringify(updatedUser));
    }
    return true;
  });
});
