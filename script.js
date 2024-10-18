function rebours(){
    let days = document.getElementById("days"),
        hours = document.getElementById("hours"),
        minutes = document.getElementById("minutes"),
        secondes = document.getElementById("secondes"),
        day_label = document.getElementById("day_label"),
        hours_label = document.getElementById("hours_label"),
        minutes_label = document.getElementById("minutes_label"),
        secondes_label = document.getElementById("secondes_label"),
        now = new Date(),
        christmas = new Date('December 24, 2024 23:59:59');

    let total_secondes = (christmas - now) / 1000;
    if(total_secondes > 0){
        let nb_days = Math.floor(total_secondes / (60 * 60 * 24));
        let nb_hours = Math.floor((total_secondes - (nb_days * 60 * 60 * 24)) / (60 * 60));
        let nb_minutes = Math.floor((total_secondes - ((nb_days * 60 * 60 * 24 + nb_hours * 60 * 60))) / 60);
        let nb_secondes = Math.floor(total_secondes - ((nb_days * 60 * 60 * 24 + nb_hours * 60 * 60 + nb_minutes * 60)));

        days.textContent = caractere(nb_days);
        hours.textContent = caractere(nb_hours);
        minutes.textContent = caractere(nb_minutes);
        secondes.textContent = caractere(nb_secondes);
        
        day_label.textContent = genre(nb_days, 'jour');
        hours_label.textContent = genre(nb_hours, 'heure');
        minutes_label.textContent = genre(nb_minutes, 'minute');
        secondes_label.textContent = genre(nb_secondes, 'seconde');
    }

    let counter = setTimeout("rebours();", 1000);
}

function caractere(nb)
{ 
    return (nb < 10) ? '0'+nb : nb;
}

function genre(nb, libelle)
{
    return (nb > 1) ? libelle+'s' : libelle;
}

rebours();


let checkbox = document.querySelectorAll("input[type=checkbox]");
checkbox.forEach(function(el){
    el.addEventListener('change',function(){
        console.log(this);    
        let checked = this.checked ? true : false;
        let ids = this.id.split('_'); 
        let id_user = ids[0];
        let id_item = ids[1];
        let status = this.checked ? 1 : 0;

        const xhttp = new XMLHttpRequest();
        
        let url = "index.php";
        let params = "?id_user="+id_user+"&id_item="+id_item+"&status="+status;
        xhttp.open("GET", url+params);
        xhttp.responseType = "json";
        xhttp.send();
    });
})

function prompt_(){
    let name = prompt("Qui es-tu ?");
    let names = ['lucas', 'sam', 'emma', 'sophie', 'paul', 'alice'];

    console.log(name);
    console.log(names);
    if(name != null && names.includes(name.toLowerCase())){
        window.location.href = "?name="+name.toLowerCase();
    }else{
        //prompt_();
    }  
}