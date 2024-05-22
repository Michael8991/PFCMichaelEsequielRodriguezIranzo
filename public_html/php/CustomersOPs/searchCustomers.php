<?php 
session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit;
}

require '../conexion.php'; 
$user = $_SESSION['user'];
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Funciones
function getOffset($page, $items_per_page) {
    return ($page - 1) * $items_per_page;
}

function countAllRecords($conn, $company_id) {
    try {
        $stmt = $conn->prepare('SELECT COUNT(*) FROM Customers WHERE CompanyID = :company_id');
        $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $stmt->execute();
        $total_items = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return 0;
    }
    return $total_items;
}

function getTotalPages($total_items, $items_per_page) {
    return ceil($total_items / $items_per_page);
}

function getCompanyID($conn, $user) {
    try {
        $sql = "SELECT CompanyID, ID FROM Users WHERE user = :userName";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userName", $user, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return null;
    }
    if ($row) {
        return $row['CompanyID'];
    } else {
        echo "Error: usuario no encontrado";
        return null;
    }
}

function getRecords($conn, $items_per_page, $offset, $company_id, $searchTerm = '') {
    try {
        
        if (empty($searchTerm)) {
            $sql = 'SELECT * FROM Customers WHERE CompanyID = :companyID LIMIT :limit OFFSET :offset';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':companyID', $company_id, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } else if (!empty($searchTerm)) {
            $searchTermWildcard = '%' . $searchTerm . '%';
            $sql = 'SELECT * FROM Customers WHERE CompanyID = :companyID AND (FirstName LIKE :searchTermWildcard OR LastName LIKE :searchTermWildcard) LIMIT :limit OFFSET :offset';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':companyID', $company_id, PDO::PARAM_INT);
            $stmt->bindParam(':searchTermWildcard', $searchTermWildcard, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
        }
        return $records;
        
    } catch (PDOException $e) {
        error_log('Error en getRecords: ' . $e->getMessage());
        return [];
    }

    
}


$company_id = getCompanyID($conn, $user); 
$total_items = countAllRecords($conn, $company_id); 
$total_pages = getTotalPages($total_items, $items_per_page);
$offset = getOffset($page, $items_per_page);

if (isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    $records = getRecords($conn, $items_per_page, $offset, $company_id, $searchTerm);
    header('Content-Type: application/json');
    echo json_encode($records);
} else {
    $records = getRecords($conn, $items_per_page, $offset, $company_id);
}
?>
