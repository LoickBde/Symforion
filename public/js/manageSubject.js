function handleDeleteSubject(event){
    const subjectId = $(this).val();

    console.log(subjectId);
    $.ajax({
        url: "/manage/subject/" + subjectId,
        method : "DELETE",
        success: function (data) {
            $('#subjectTable').DataTable().row(event.target.closest("tr")).remove().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#alert-container").append(createAlert("danger", "Erreur lors de la suppression de la matière", `Erreur !`));
        }
    });
}

$(function () {

    let promoTable = $('#subjectTable').DataTable({
        columnDefs: [
            { width: '5%', targets: 0 },
            { width: '45%', targets: 1 },
            { width: '45%', targets: 2 }
        ],
        fixedColumns: true
    });

    $(document).on('click','.deleteSubject',handleDeleteSubject);

    $("#addSubjectBtn").click(() => {
        const subjectName = $("#subjectName").val().trim();
        const teacherId = $("#selectTeacher").val()

        if(subjectName !== "" || teacherId !== ""){
            $.post({
                url: '/manage/subject',
                data: {
                    'name' : subjectName,
                    'teacherId' : teacherId
                },
                success : (data) => {
                    promoTable.row.add([
                        data.id,
                        data.name,
                        data.teacherFistname + " " + data.teacherLastname,
                        "<button type=\"button\" class=\"deleteSubject btn btn-danger\" value=\""+data.id+ "\"><i class=\"bi bi-trash\"></i></button>"
                    ]).draw();

                    $("#alert-container").append(createAlert("success", `La matière ${name} a bien été ajoutée !`, `Succès !`));
                },
                error: (data) => {
                    $("#alert-container").append(createAlert("danger", "Erreur lors de la création de la matière !" + data.message, `Erreur !`));
                }
            })
        }
    });

});