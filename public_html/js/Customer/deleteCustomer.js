function openDeleteCustomerModal() {
    $('#confirmarEliminar').modal('show');
}
function closeDeleteCustomerModal() {
    $('#confirmarEliminar').modal('hide');
}

function deleteCustomer(id){
    const elementoIdInput = document.getElementById('elementoIdInput');
    $('#confirmarEliminar').modal('show');
            elementoIdInput.value = id;

}