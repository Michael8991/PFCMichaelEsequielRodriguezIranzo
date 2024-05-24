function openDeleteProjectModal() {
    $('#deleteProjectModal').modal('show');
}
function closeDeleteProjectModal() {
    $('#deleteProjectModal').modal('hide');
}

function deleteProject(id){
    const elementoIdInput = document.getElementById('elementoIdInput');
    $('#deleteProjectModal').modal('show');
            elementoIdInput.value = id;

}