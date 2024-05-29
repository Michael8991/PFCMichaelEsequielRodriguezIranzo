<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

    require '../conexion.php';

    $user_name = $_SESSION['user'];
    $bill_id = $_POST['elemento_id'];
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
    
    if($bill_id){
        try{
            $sql = "SELECT CompanyID FROM Bills WHERE BillID = :bill_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("bill_id", $bill_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        }catch(PDOException $e){
            echo 'Error'.$e->getMessage();
        }
        if($resultados){
            $bill_company_id = $resultados[0]['CompanyID'];
        }else{
            // echo 'Error al seleccionar el id de la compañía del presupuesto'.$budget_id;
            header("Location: ../views/facturasPage.php");
            exit;
        }
    
        if($bill_company_id != $company_id){
            // echo 'Error al comparar el id de la compañía del presupuesto'.$budget_company_id;
            header("Location: ../views/facturasPage.php");
            exit;
        }
    }else{
        // echo 'Error con el id de la compañía del presupuesto'.$project_id;
        header("Location: ../views/facturasPage.php");
        exit;
        
    }
    try{
        $sql = "DELETE FROM Bills WHERE BillID = :bill_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":bill_id", $bill_id, PDO::PARAM_STR);
        $stmt->execute();
    }catch(PDOException $e){
        echo 'error'.$e->getMessage();
    }
    header("Location: ../views/facturasPage.php");
    exit;
        

?>