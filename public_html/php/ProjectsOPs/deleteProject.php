<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

    require '../conexion.php';

    $user_name = $_SESSION['user'];
    $project_id = $_POST['elemento_id'];
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
    
    if($project_id){
        try{
            $sql = "SELECT CompanyID FROM Projects WHERE ProjectID = :project_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("project_id", $project_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        }catch(PDOException $e){
            echo 'Error'.$e->getMessage();
        }
        if($resultados){
            $project_company_id = $resultados[0]['CompanyID'];
        }else{
            header("Location: ../views/projectsPage.php");
            exit;
        }
    
        if($project_company_id != $company_id){
            header("Location: ../views/projectsPage.php");
            exit;
        }
    }else{
        header("Location: ../views/projectsPage.php");
        exit;
        
    }

    try{
        $sql = "DELETE FROM Projects WHERE ProjectID = :project_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":project_id", $project_id, PDO::PARAM_STR);
        $stmt->execute();
    }catch(PDOException $e){
        echo 'error'.$e->getMessage();
    }
    header("Location: ../views/projectsPage.php");
    exit;
        

?>