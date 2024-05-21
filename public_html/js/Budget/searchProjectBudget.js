const searchProjectInput = document.getElementById('searchProjectInput');
const projectList = document.getElementById("projectDisplayer");

const projectInputID = document.getElementById("projectInputID");
const projectInputName = document.getElementById("projectInputName");
const searchCustomerInput = document.getElementById("searchCustomerInput");



document.getElementById("openBtnModalProjects").addEventListener("click", seachAllProjects);

searchProjectInput.addEventListener('input', () => {
    let projects;
    const searchTerm = searchProjectInput.value;
    fetch(`../../php/BudgetOPs/buscarProyectoOP.php?term=${searchTerm}`)
        .then(response => response.json())
        .then(data => {
            projects = data;
            projectList.innerHTML= ``;
            // Construir la tabla de proyectos
            const projectsTable = document.createElement('table');
            const projectsTableHead = `<thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Fecha de incio</th>
                                            <th scope="col">Fecha de fin</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Cliente</th>
                                            </tr>
                                        </thead>`;
            projectsTable.innerHTML= projectsTableHead;
            projectsTable.classList.add('table');

            const projectsTableBody = document.createElement('tbody');
            projectsTableBody.classList.add('table-group-divider');
            projects.forEach(function(project) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<th scope="row">
                                    <input class="form-check-input me-1" type="radio" name="projects" value="${project.ProjectID}" id="project${project.ProjectID}">
                                </th>
                                <td>${project.ProjectName}</td>
                                <td>${project.StartDate}</td>
                                <td>${project.EndDate}</td>
                                <td>${project.ProjectStatus}</td>
                                <td>${project.FirstName} ${project.LastName}</td>`;
                projectsTableBody.appendChild(tr);
            });
            projectsTable.appendChild(projectsTableBody);
            projectList.appendChild(projectsTable);
        })
        .catch(error => console.error('Error:', error));
});

let projects;

function seachAllProjects(){    
    projectList.innerHTML = ``;
    
    // Se realiza una solicitud AJAX para obtener los proyectos
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parsear la respuesta JSON
            projects = JSON.parse(xhr.responseText);
            
            // Construir la tabla de proyectos
            const projectsTable = document.createElement('table');
            const projectsTableHead = `<thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Fecha de incio</th>
                                            <th scope="col">Fecha de fin</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Cliente</th>
                                            </tr>
                                        </thead>`
            projectsTable.innerHTML= projectsTableHead;
            projectsTable.classList.add('table')

            const projcetsTableBody = document.createElement('tbody');
            projcetsTableBody.classList.add('table-group-divider')
            projects.forEach(function(project) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<th scope="row">
                                    <input class="form-check-input me-1" type="radio" name="projects" value="${project.ProjectID}" id="project${project.ProjectID}">
                                </th>
                                <td>${project.ProjectName}</td>
                                <td>${project.StartDate}</td>
                                <td>${project.EndDate}</td>
                                <td>${project.ProjectStatus}</td>
                                <td>${project.FirstName} ${project.LastName}</td>`;
                projcetsTableBody.appendChild(tr);
            });
            projectsTable.appendChild(projcetsTableBody);
            projectList.appendChild(projectsTable);
        }
    };
    xhr.open("GET", "../../php/BudgetOPs/BuscarProyectoOP.php", true);
    xhr.send();
};

const confirmProjectBtn = document.getElementById('confirmProjectBtn');
let selectedProjectId = -1;
confirmProjectBtn.addEventListener('click', () =>{
    
    const checkedInputs = document.querySelectorAll('input[name="projects"]:checked');
    
    if(checkedInputs.length === 0){
        //validaciones
        validateProjectSelected(selectedProjectId);
    }else if(checkedInputs.length > 1){
        console.log('Solo puede seleccionar un elemento');
    }else{
        checkedInputs.forEach(option =>{
            selectedProjectId = option.value;
        })
        closeProjectsModal();
        // Encuentra el proyecto seleccionado por su ID
        const selectedProject = projects.find(project => project.ProjectID === selectedProjectId);

        if (selectedProject) {
            const selectedProjectName = selectedProject.ProjectName;
            const selectedCustomerName = selectedProject.FirstName +' '+ selectedProject.LastName;
            projectInputID.value = selectedProjectId;
            projectInputName.value = selectedProjectName;
            searchCustomerInput.value = selectedCustomerName;
            validateProjectSelected(selectedProjectId);
        }
    }
});

