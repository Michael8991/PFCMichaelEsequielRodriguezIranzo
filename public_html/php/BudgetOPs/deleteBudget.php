<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

    require '../conexion.php';

    $user_name = $_SESSION['user'];
    $budget_id = $_POST['elemento_id'];
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
    
    if($budget_id){
        try{
            $sql = "SELECT CompanyID FROM Budgets WHERE BudgetID = :budget_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("budget_id", $budget_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        }catch(PDOException $e){
            echo 'Error'.$e->getMessage();
        }
        if($resultados){
            $budget_company_id = $resultados[0]['CompanyID'];
        }else{
            // echo 'Error al seleccionar el id de la compañía del presupuesto'.$budget_id;
            header("Location: ../views/presupuestosPage.php");
            exit;
        }
    
        if($budget_company_id != $company_id){
            // echo 'Error al comparar el id de la compañía del presupuesto'.$budget_company_id;
            header("Location: ../views/presupuestosPage.php");
            exit;
        }
    }else{
        // echo 'Error con el id de la compañía del presupuesto'.$project_id;
        header("Location: ../views/presupuestosPage.php");
        exit;
        
    }
    try{
        $sql = "DELETE FROM Budgets WHERE BudgetID = :budget_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":budget_id", $budget_id, PDO::PARAM_STR);
        $stmt->execute();
    }catch(PDOException $e){
        echo 'error'.$e->getMessage();
    }
    header("Location: ../views/presupuestosPage.php");
    exit;
        

?>