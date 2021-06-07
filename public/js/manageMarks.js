let selectPromo = $('#select-promo');
let selectStudent = $('#select-student');

$('document').ready(function (){
    let idPromo = $(selectPromo, "option:selected" ).val();
    fetchStudentByPromo(idPromo);
});

/**
 * Evenement onChange sur le select de séléction de promo
 */
selectPromo.on('change', function() {
   let idPromo = $(selectPromo, "option:selected" ).val();
   fetchStudentByPromo(idPromo);
});

/**
 * Appel AJAX qui permet de récupérer les étudiants d'une promo
 */
function fetchStudentByPromo(promoId){
    $.ajax({
        url : '/manage/marks/promo/' + promoId + '/students',
        success : function(data, statut){
            selectStudent.find('option').remove();
            if(statut === 'success'){
                for(i=0; i<data.length; i++){
                    student = data[i];
                    selectStudent.append($("<option></option>")
                        .attr("value", student.id)
                        .text(student.lastname + " - " + student.firstname));
                }
            } else {
                alert("Une erreur est survenue lors de la récupération des élèves de cette promo");
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("Une erreur est survenue lors de la récupération des élèves de cette promo");
        }
    });
}