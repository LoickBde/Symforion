let selectSubject = $('#select-subject');
let selectPromo = $('#select-promo');
let selectStudent = $('#select-student');
let selectType = $('#select-type');
let markInput = $('#mark-input');
let coefInput = $('#coef-input');
let descInput = $('#desc-input');

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

/**
 * Vérifier si l'input note est OK
 */
function checkMarkInput(){
    let markValue = markInput.val();

    if(markValue.trim() === "")
        return;

    markValue = markValue.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');

    if(markValue >20)
        markValue=20;
    if(markValue < 0)
        markValue=0;

    markInput.val(markValue);
}

/**
 * Vérifier si l'input coef est OK
 */
function checkCoefInput(){
    let coefValue = coefInput.val();

    if(coefValue.trim() === "")
        return;

    coefValue = coefValue.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');

    if(coefValue >20)
        coefValue=20;
    if(coefValue <= 0)
        coefValue=1;

    coefInput.val(coefValue);
}

/**
 * Nettoyer les input du formulaire
 */
$("#btn-clear").click(function() {
    selectType.val("CB").select();
    markInput.val("");
    coefInput.val("");
    descInput.val("");
});