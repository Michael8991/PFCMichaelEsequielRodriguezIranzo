function openDeleteServiceModal() {
    $('#confirmarEliminar').modal('show');
}
function closeDeleteServiceModal() {
    $('#confirmarEliminar').modal('hide');
}

function deleteService(id){
    const elementoIdInput = document.getElementById('elementoIdInput');
    $('#confirmarEliminar').modal('show');
            elementoIdInput.value = id;

}