document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', function() {
        var searchTerm = this.value.trim(); // Obtener el término de búsqueda y eliminar espacios en blanco

        // Realizar la solicitud AJAX solo si el término de búsqueda no está vacío
        if (searchTerm !== '') {
            // Crear una nueva solicitud XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Definir la URL del script PHP que manejará la búsqueda
            var url = '../../php/CustomersOps/searchCustomers.php?searchTerm=' + encodeURIComponent(searchTerm);

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

                        // Crear las celdas para cada campo del registro
                        let customerName = record.FirstName + ' ' + record.LastName
                        row.innerHTML = `
                            <td>${customerName}</td>
                            <td>${record.Email}</td>
                            <td class="text-center">${record.PhoneNumber}</td>
                            <td class="text-center">${record.Address}</td>
                            <td>
                                <a class="budgetPDF ms-auto me-2 text-primary" href=""><i class="fa-solid fa-file"></i></a>
                                <a class="editar mx-auto text-success" href="budgetDetails.php?id=${record.CustomerID}"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a class="borrar me-auto ms-2 text-danger" href="../js/dashBoard.js" data-id="${record.CustomerID}"><i class="fa-solid fa-trash"></i></a>
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
