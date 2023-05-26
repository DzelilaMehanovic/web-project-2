var StudentService = {
  init: function () {
    $("#addStudentForm").validate({
      submitHandler: function (form) {
        var student = Object.fromEntries(new FormData(form).entries());
        StudentService.addStudent(student);
        form.reset();
      },
    });
    $("#editStudentForm").validate({
      submitHandler: function (form) {
        var student = Object.fromEntries(new FormData(form).entries());
        StudentService.editStudent(student);
      },
    });

    StudentService.get_students_rest();
  },
  getStudents: function () {
    $.get("rest/students", function (data) {
      var html = "";
      for (var i = 0; i < data.length; i++) {
        data[i].email = data[i].email ? data[i].email : "-";
        data[i].edit_student =
          '<button class="btn btn-info" onClick="StudentService.showEditDialog(' +
          data[i].id +
          ')">Edit Student</button>';
        data[i]._student =
          '<button class="btn btn-danger" onClick="StudentService.openConfirmationDialog(' +
          data[i].id +
          ')"> Student</button>';
        /*html +=
          "<tr>" +
          "<td>" +
          data[i].first_name +
          "</td>" +
          "<td>" +
          data[i].last_name +
          "</td>" +
          "<td>" +
          (data[i].email ? data[i].email : "No data") +
          "</td>" +
          "<td>" +
          (data[i].password ? data[i].password : "No data") +
          "</td>" +
          '<td><button class="btn btn-info" onClick="StudentService.showEditDialog(' +
          data[i].id +
          ')">Edit Student</button></td>' +
          '<td><button class="btn btn-danger" onClick="StudentService.openConfirmationDialog(' +
          data[i].id +
          ')"> Student</button></td>' +
          "</tr>";*/
      }
      //$("#students-table").html(html);

      Utils.datatable(
        "students-table",
        [
          { data: "first_name", title: "Name" },
          { data: "last_name", title: "Surname" },
          { data: "password", title: "Password" },
          { data: "email", title: "Email" },
          { data: "edit_student", title: "Edit Student" },
          { data: "_student", title: " Student" },
        ],
        data
      );

      console.log(data);
    });
  },

  addStudent: function (student) {
    console.log("post");
    $.ajax({
      url: "rest/student",
      type: "POST",
      beforeSend: function (xhr) {
        xhr.setRequestHeader(
          "Authorization",
          localStorage.getItem("user_token")
        );
      },
      data: JSON.stringify(student),
      contentType: "application/json",
      dataType: "json",
      success: function (student) {
        $("#addStudentModal").modal("hide");
        toastr.success("Student has been added!");
        StudentService.getStudents();
      },
    });
  },

  showEditDialog: function (id) {
    $("#editStudentModal").modal("show");
    $("#editModalSpinner").show();
    $("#editStudentForm").hide();
    $.ajax({
      url: "rest/students/" + id,
      beforeSend: function (xhr) {
        xhr.setRequestHeader(
          "Authorization",
          localStorage.getItem("user_token")
        );
      },
      type: "GET",
      success: function (data) {
        console.log(data);
        $("#edit_first_name").val(data.first_name);
        $("#edit_last_name").val(data.last_name);
        $("#edit_email").val(data.email);
        $("#edit_password").val(data.password);
        $("#edit_student_id").val(data.id);
        $("#editModalSpinner").hide();
        $("#editStudentForm").show();
      },
    });
  },

  editStudent: function (student) {
    console.log("edit");
    $.ajax({
      url: "rest/student/" + student.id,
      beforeSend: function (xhr) {
        xhr.setRequestHeader(
          "Authorization",
          localStorage.getItem("user_token")
        );
      },
      type: "PUT",
      data: JSON.stringify(student),
      contentType: "application/json",
      dataType: "json",
      success: function (result) {
        toastr.success("Student has been updated successfully");
        $("#editStudentModal").modal("toggle");
        StudentService.getStudents();
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error("Error! Student has not been updated.");
      },
    });
  },

  openConfirmationDialog: function (id) {
    $("#deleteStudentModal").modal("show");
    $("#delete-student-body").html(
      "Do you want to delete student with ID = " + id
    );
    $("#student_id").val(id);
  },

  deleteStudent: function () {
    $.ajax({
      url: "rest/students/" + $("#student_id").val(),
      beforeSend: function (xhr) {
        xhr.setRequestHeader(
          "Authorization",
          localStorage.getItem("user_token")
        );
      },
      type: "DELETE",
      success: function (response) {
        console.log(response);
        $("#deleteStudentModal").modal("hide");
        toastr.success(response.message);
        StudentService.getStudents();
        //alert('deleted')
      },
      error: function (XMLHttpRequest, textStatus, errorThrow) {
        console.log("Error: " + errorThrow);
      },
    });
  },
  get_students_rest: function () {
    RestClient.get(
      "students",
      function (data) {
        for (var i = 0; i < data.length; i++) {
          data[i].email = data[i].email ? data[i].email : "-";
          data[i].edit_student =
            '<button class="btn btn-info" onClick="StudentService.showEditDialog(' +
            data[i].id +
            ')">Edit Student</button>';
          data[i].delete_student =
            '<button class="btn btn-danger" onClick="StudentService.openConfirmationDialog(' +
            data[i].id +
            ')">Delete Student</button>';
          /*html +=
              "<tr>" +
              "<td>" +
              data[i].first_name +
              "</td>" +
              "<td>" +
              data[i].last_name +
              "</td>" +
              "<td>" +
              (data[i].email ? data[i].email : "No data") +
              "</td>" +
              "<td>" +
              (data[i].password ? data[i].password : "No data") +
              "</td>" +
              '<td><button class="btn btn-info" onClick="StudentService.showEditDialog(' +
              data[i].id +
              ')">Edit Student</button></td>' +
              '<td><button class="btn btn-danger" onClick="StudentService.openConfirmationDialog(' +
              data[i].id +
              ')">Delete Student</button></td>' +
              "</tr>";*/
        }
        //$("#students-table").html(html);

        Utils.datatable(
          "students-table",
          [
            { data: "first_name", title: "Name" },
            { data: "last_name", title: "Surname" },
            { data: "password", title: "Password" },
            { data: "email", title: "Email" },
            { data: "edit_student", title: "Edit Student" },
            { data: "delete_student", title: "Delete Student" },
          ],
          data
        );

        console.log(data);
      },
      function (data) {
        toastr.error(data.responseText);
      }
    );
  },
};
