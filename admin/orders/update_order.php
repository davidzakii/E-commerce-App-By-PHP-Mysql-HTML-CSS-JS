<?php
include_once '../inc/config.php';

if(isset($_POST['code']) && isset($_POST['isPaid']) && isset($_POST['isDelivered'])) {
    $code = $_POST['code'];
    $isPaid = $_POST['isPaid'];
    $isDelivered = $_POST['isDelivered'];
    
    // Prepare and execute the update query
    $updateQuery = "UPDATE `order` SET `isPaid` = :isPaid, `delivered` = :isDelivered WHERE code = :code";
    $stmt = $connect->prepare($updateQuery);
    $stmt->bindParam(':isPaid', $isPaid);
    $stmt->bindParam(':isDelivered', $isDelivered);
    $stmt->bindParam(':code', $code);
    $stmt->execute();

    // Optionally, you can check if the query was successful
    if($stmt->rowCount() > 0) {
        // Send a success response back to the client
        echo "Order updated successfully";
    } else {
        // Send an error response back to the client
        echo "Error updating order";
    }
} else {
    // Send an error response back to the client if required parameters are missing
    echo "Missing parameters";
}
?>
