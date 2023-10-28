document.addEventListener("DOMContentLoaded", function(){
    const editBtn = document.getElementById("editBtn");
    const saveBtn = document.getElementById("saveBtn");
    const deleteForm = document.getElementById("deleteForm");
    const cancelBtn = document.getElementById("cancelBtn");
    const resetPwBtn = document.getElementById("resetPwBtn");
  
    console.log('RUI');

    editBtn.addEventListener("click", function(event){

        // Habilitar campos editáveis
        document.querySelectorAll("input[readonly]").forEach(function(input){
            input.removeAttribute("readonly");
        });
        document.querySelectorAll("input[type=checkbox]").forEach(function(checkbox){
            checkbox.removeAttribute("disabled");
        });

        // Mostrar botão "Guardar" e esconder o botão "Editar"
        editBtn.style.display = "none";
        saveBtn.style.display = "inline-block";
        deleteForm.style.display = "inline-block";
        cancelBtn.style.display = "inline-block";
        resetPwBtn.style.display = "inline-block";
    });

    cancelBtn.addEventListener("click", function (event) {
        event.preventDefault();
        // Desabilitar campos editáveis
        document.querySelectorAll("input").forEach(function (input) {
            input.setAttribute("readonly", true);
        });
        document.querySelectorAll("input[type=checkbox]").forEach(function (checkbox) {
            checkbox.setAttribute("disabled", true);
        });
    
        // Esconder botão "Guardar" e "Apagar" e mostrar o botão "Editar"
        editBtn.style.display = "inline-block";
        saveBtn.style.display = "none";
        deleteForm.style.display = "none";
        cancelBtn.style.display = "none";
        resetPwBtn.style.display = "none";

    });
});