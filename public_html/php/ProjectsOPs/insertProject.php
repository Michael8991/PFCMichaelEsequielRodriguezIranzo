<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require '../conexion.php';

$user_name = $_SESSION['user'];

try {
    $sql = "SELECT CompanyID, ID FROM Users WHERE user = :userName";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":userName", $user_name, PDO::PARAM_STR);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user_data) {
        $company_id = $user_data['CompanyID'];
        $user_id = $user_data['ID'];
    } else {
        echo "Error: Usuario no encontrado";
        exit;
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}

$project_name_error = $issue_date_error = $exp_date_error = $project_place_error = $project_priority_error = $project_description_error = $project_customer_id_error = "";

$date_regex = "/^\d{4}-\d{2}-\d{2}$/"; // Formato YYYY-MM-DD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = $issue_date = $exp_date = $project_place = $project_priority = $project_description = $project_customer_id = $project_customer_Name = "";

    if (empty(trim($_POST["proyectNameInput"]))) {
        $project_name_error = "El nombre del proyecto es requerido";
    } else {
        $project_name = $_POST["proyectNameInput"];
    }
   
    if (empty(trim($_POST["fechaEmisionInput"])) || !preg_match($date_regex, $_POST['fechaEmisionInput'])) {
        $issue_date_error = "La fecha de emisión no es válida: " . $_POST["fechaEmisionInput"];
    } else {
        $issue_date = $_POST["fechaEmisionInput"];
    }
    
    if (empty(trim($_POST["fechaValidezInput"])) || !preg_match($date_regex, $_POST['fechaValidezInput'])) {
        $exp_date_error = "La fecha de expiración no es válida: " . $_POST["fechaValidezInput"];
    } else {
        $exp_date = $_POST["fechaValidezInput"];
    }
    
    if (empty(trim($_POST["proyectPlaceInput"]))) {
        $project_place_error = "La ubicación del proyecto es requerida";
    } else {
        $project_place = $_POST["proyectPlaceInput"];
    }
    
    if (empty($_POST["proyectPriorityInput"]) || $_POST["proyectPriorityInput"] === "Seleccione la prioridad") {
        $project_priority_error = "La prioridad del proyecto es requerida";
    } else {
        $project_priority = $_POST["proyectPriorityInput"];
    }
    
    if (empty($_POST["floatingTextarea2"])) {
        $project_description_error = "La descripción del proyecto es requerida";
    } else {
        $project_description = $_POST["floatingTextarea2"];
    }
    
    if (empty($_POST["customerInputID"]) || !is_numeric($_POST["customerInputID"])) {
        $project_customer_id_error = "El cliente no es correcto. Póngase en contacto con el desarrollador.";
    } else {
        $project_customer_id = $_POST["customerInputID"];
        try {
            $sql = "SELECT CompanyID, FirstName, LastName FROM Customers WHERE CustomerID = :customerID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":customerID", $project_customer_id, PDO::PARAM_INT);
            $stmt->execute();
            $customer_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($customer_data) {
                $company_id_customer = $customer_data['CompanyID'];
                $customer_First_Name = $customer_data['FirstName'];
                $customer_Last_Name = $customer_data['LastName'];
                if ($company_id_customer == $company_id) {
                    $project_customer_Name = $customer_First_Name . ' ' . $customer_Last_Name;
                } else {
                    $project_customer_id_error = "El cliente no es correcto. Póngase en contacto con el desarrollador.";
                    echo $project_customer_id_error;
                    exit;
                }
            } else {
                $project_customer_id_error = "El cliente no es correcto. Póngase en contacto con el desarrollador.";
                echo $project_customer_id_error;
                exit;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    }
    
    $project_status = 'Pendiente';
    
    if (empty($project_name_error) && empty($issue_date_error) && empty($exp_date_error) && empty($project_place_error) && empty($project_priority_error) && empty($project_description_error) && empty($project_customer_id_error)) {
        
        try {
            $sqlInsertionProject = "INSERT INTO Projects (ProjectName, ProjectDescription, StartDate, EndDate, ProjectStatus, Place, ProjectPriority, CompanyID, CustomerID, CustomerName) 
            VALUES (:ProjectName, :ProjectDescription, :ProjectIssueDate, :ProjectValidityDate, :ProjectStatus, :ProjectPlace, :ProjectPriority, :CompanyID, :customerID, :customerName)";
            $stmt = $conn->prepare($sqlInsertionProject);
            // Bind parameters
            $stmt->bindParam(':ProjectName', $project_name, PDO::PARAM_STR);
            $stmt->bindParam(':ProjectDescription', $project_description, PDO::PARAM_STR);
            $stmt->bindParam(':ProjectIssueDate', $issue_date, PDO::PARAM_STR);
            $stmt->bindParam(':ProjectValidityDate', $exp_date, PDO::PARAM_STR);
            $stmt->bindParam(':ProjectStatus', $project_status, PDO::PARAM_STR);
            $stmt->bindParam(':ProjectPlace', $project_place, PDO::PARAM_STR);
            $stmt->bindParam(':ProjectPriority', $project_priority, PDO::PARAM_STR);
            $stmt->bindParam(':CompanyID', $company_id, PDO::PARAM_INT);
            $stmt->bindParam(':customerID', $project_customer_id, PDO::PARAM_INT);
            $stmt->bindParam(':customerName', $project_customer_Name, PDO::PARAM_STR);
            $stmt->execute();
            
        } catch (PDOException $e) {
            echo 'Error inserción de Proyecto: ' . $e->getMessage();
        }
        
        header("Location: ../views/projectsPage.php");
        exit;
        
    }else{
        echo "Hay errores";
    }
}
?>
