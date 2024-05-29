function openDeleteBillModal() {
    $('#confirmarEliminar').modal('show');
}
function closeDeleteBillModal() {
    $('#confirmarEliminar').modal('hide');
}

function deleteBill(id){
    const elementoIdInput = document.getElementById('elementoIdInput');
    $('#confirmarEliminar').modal('show');
            elementoIdInput.value = id;

}