function openDeleteBudgetModal() {
    $('#confirmarEliminar').modal('show');
}
function closeDeleteBudgetModal() {
    $('#confirmarEliminar').modal('hide');
}

function deleteBudget(id){
    const elementoIdInput = document.getElementById('elementoIdInput');
    $('#confirmarEliminar').modal('show');
            elementoIdInput.value = id;

}