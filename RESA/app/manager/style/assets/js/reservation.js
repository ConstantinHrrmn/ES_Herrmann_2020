$(document).ready(function() {
    var date_input = $('input[name="date"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    };
    date_input.datepicker(options);
})


// Pour la date choisie, nous vérifiions les heures d'ouvertures du restaurant.
// Si le restaurant est fermé, le restaurant affiche fermer
// Si le restaurant est ouvert, on affiche les horaires et le boutton pour valider la réservation
function DateChoosen(etab){
    data = document.getElementById("date").value;
    var date = data.split("/");
    console.log(date);
    var finalDate = date[2]+"-"+date[0]+"-"+date[1];
    var link = "http://localhost/Travail_diplome_ES_2020/RESA/api/v2/etablishment/schudle/get?dayschudle&idEtab="+etab+"&date="+finalDate;
    $.getJSON(link, function(data) {
        var sel = document.getElementById('hour');
        removeOptions(sel);
        if(data.length == 0){
            document.getElementById("hourdiv").style.display = "none";
            document.getElementById("close").style.display = "block";
            document.getElementById("rechercher").style.display = "none";
        }else{
            data.forEach(element => {
                document.getElementById("close").style.display = "none";
                document.getElementById("hourdiv").style.display = "block";
                document.getElementById("rechercher").style.display = "block";
                // create new option element
                var opt = document.createElement('option');
                opt.value = element;
                opt.text = element;
                sel.appendChild(opt);
            });
        }
        
    });
}

function removeOptions(selectElement) {
    var i, L = selectElement.options.length - 1;
    for(i = L; i >= 0; i--) { b
       selectElement.remove(i);
    }
 }
