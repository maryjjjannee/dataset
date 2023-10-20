<?php
// include_once("server.php");

// function insertInstructor($conn, $instructor)
// {
//     $sql = "INSERT INTO instructor (`name`, dept_id, salary) VALUES (:NAME, :dept_id, :salary)";
//     $stm = $conn->prepare($sql);
//     $stm->execute($instructor);
// }

// function updateInstructor($conn, $instructor)
// {
//     $sql = "UPDATE instructor 
//     SET `name`=:NAME, dept_id=:dept_id, salary=:salary
//     WHERE id=:ID";
//     $stm = $conn->prepare($sql);
//     $stm->execute($instructor);
// }

// function allInstructors($conn)
// {
//     $result = $conn->query("SELECT * FROM `instructor`");
//     $instructors = $result->fetchAll(PDO::FETCH_ASSOC);
//     return $instructors;
// }

// $input = json_decode(file_get_contents('php://input'), TRUE);

// try {
//     $conn->beginTransaction();
//     foreach ($input as $data) {
//         if (isset($data['ID'])) {
//             updateInstructor($conn, $data);
//         } else {
//             insertInstructor($conn, $data);
//         }
//     }
//     $conn->commit();
    
//     $instructors = allInstructors($conn);
//     echo json_encode($instructors);
    
// } catch (Exception $ex) {
//     $conn->rollback();
//     $message = ['error' => true, 'message'=> $ex->getMessage()];
//     echo json_encode($message);
// }
?>