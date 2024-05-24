function truncateString(string, length = 25, trailing = '...') {
    // Si la longitud del string es mayor que el límite definido
    if (string.length > length) {
        // Truncar el string al límite y agregar el sufijo
        return string.substring(0, length - trailing.length) + trailing;
    } else {
        // Si no es mayor, devolver el string tal cual
        return string;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', function() {
        var searchTerm = this.value.trim(); // Obtener el término de búsqueda y eliminar espacios en blanco

        // Realizar la solicitud AJAX solo si el término de búsqueda no está vacío
        if (searchTerm !== '') {
            // Crear una nueva solicitud XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Definir la URL del script PHP que manejará la búsqueda
            var url = '../../php/ProjectsOPs/searchProjects.php?searchTerm=' + encodeURIComponent(searchTerm);

            // Abrir la solicitud AJAX
            xhr.open('GET', url, true);

            // Definir la función de callback que se ejecutará cuando se complete la solicitud
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // La solicitud se completó correctamente
                    let responseArray = JSON.parse(xhr.responseText);
                    const budgetsTbody = document.getElementById('budgetsTbody');
                    budgetsTbody.innerHTML = ''; // Limpiar el contenido actual del tbody

                    // Iterar sobre cada registro en responseArray
                    responseArray.forEach(function(record) {
                        // Crear una fila de la tabla para cada registro
                        const row = document.createElement('tr');
                        row.classList.add('filaTablaReforma', 'px-2', 'border-bottom');
                        let projectName = truncateString(record.ProjectName, 30);
                        let customerName = truncateString(record.CustomerName, 30);
                        let projectPlace = truncateString(record.Place, 25);
                        // Crear las celdas para cada campo del registro
                        row.innerHTML = `
                            <td>${projectName}</td>
                            <td>${customerName}</td>
                            <td class="text-center">${record.ProjectPriority}</td>
                            <td class="text-center">${record.EndDate}</td>
                            <td class="text-center d-flex align-items-center"> <p class="estado-${record.ProjectStatus}">${record.ProjectStatus}</p></td>
                            <td class="text-center">${projectPlace}</td>
                            <td>
                                <a class="editar ms-auto me-2 text-success" href="projectDetails.php?id=${record.ProjectID}"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a class="borrar me-auto ms-2 text-danger" id="deleteProjectInput" onclick="deleteProject(${record.ProjectID})" data-id="${record.ProjectID}"><i class="fa-solid fa-trash"></i></a>
                            </td>`;

                        // Agregar la fila a la tabla
                        budgetsTbody.appendChild(row);
                    });
                } else {
                    // La solicitud falló
                    console.error('Error en la solicitud AJAX:', xhr.statusText);
                }
            };

            // Enviar la solicitud
            xhr.send();
        } else {

        }
    });
});

