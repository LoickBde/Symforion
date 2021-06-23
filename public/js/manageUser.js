function handleDeleteUser(event){
    const userId = $(this).val();

    console.log(userId);
    $.ajax({
        url: "/manage/user/" + userId,
        method : "DELETE",
        success: function (data) {
            $('#userTable').DataTable().row(event.target.closest("tr")).remove().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#alert-container").append(createAlert("danger", "Erreur lors de la suppression de l'utiliseur", `Erreur !`));
        }
    });
}

function handleAddUserSucces(data){
    $('.modal').modal('hide')

    $('#userTable').DataTable().row.add([
        data.id,
        data.email,
        data.firstname,
        data.lastname,
        data.role,
        "<button type=\"button\" class=\"deleteuser btn btn-danger\" value=\""+data.id+ "\"><i class=\"bi bi-trash\"></i></button>"
    ]).draw();

    $("#alert-container").append(createAlert("success", "L'utilisateur " + data.firstname + " " + data.lastname + " a bien été ajouté !", `Succès !`));
    console.log('coucou');
}

function generatePassword(){
    return Math.random().toString(36).slice(-10);
}

$(function () {

    let userTable = $('#userTable').DataTable({
        columnDefs: [
            { width: '5%', targets: 0 },
        ],
    });

    $(document).on('click','.deleteUser',handleDeleteUser);

    $('.dispModal').click(() => {
        $(".emailInput").val("");
        $(".passwordInput").val(generatePassword());
        $(".firstnameInput").val("");
        $(".lastnameInput").val("");
    });

    $("#addStudentBtn").click(() => {
        const email = $("#studentEmail").val().trim();
        const password = $("#studentPassword").val().trim();
        const firstname = $("#studentFirstName").val().trim();
        const lastname = $("#studentLastName").val().trim();
        const promo =$("#inputPromo").val();

        if(email !== "" && password !== "" && firstname !== "" && lastname !== ""){
            $.post({
                url: '/manage/user',
                data: {
                    'email' : email,
                    'password' : password,
                    'firstname' : firstname,
                    'lastname' : lastname,
                    'promo' : promo,
                    'roles' : [
                        "ROLE_USER",
                        "ROLE_STUDENT"
                    ]
                },
                success : handleAddUserSucces,
                error: (data) => {
                    $("#alert-container").append(createAlert("danger", "Erreur lors de la création de l'utilisateur !" + data.message, `Erreur !`));
                }
            })
        }
    });


    $("#addTeacherBtn").click(() => {
        const email = $("#teacherEmail").val().trim();
        const password = $("#teacherPassword").val().trim();
        const firstname = $("#teacherFirstName").val().trim();
        const lastname = $("#teacherLastName").val().trim();
        const promos = $("#inputPromoTeacher").val();

        if(email !== "" && password !== "" && firstname !== "" && lastname !== ""){
            $.post({
                url: '/manage/user',
                data: {
                    'email' : email,
                    'password' : password,
                    'firstname' : firstname,
                    'lastname' : lastname,
                    'promos' : promos,
                    'roles' : [
                        "ROLE_USER",
                        "ROLE_TEACHER"
                    ]
                },
                success : handleAddUserSucces,
                error: (data) => {
                    $("#alert-container").append(createAlert("danger", "Erreur lors de la création de l'utilisateur !" + data.message, `Erreur !`));
                }
            })
        }
    });

});