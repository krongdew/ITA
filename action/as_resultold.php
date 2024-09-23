<?php

include 'connect.php';
// Example SQL query to fetch data
function getAssessmentResults($assessmentID) {
    global $conn;


    // Prepare SQL query to fetch assessment results
    $sql = "SELECT rs.QuestionID, q.QuestionOrder, q.QuestionType,q.QuestionText, rs.Service, rs.Date, rs.Choices, rs.Rating, rs.Comment
            FROM sa_respondent r
            INNER JOIN sa_response rs ON r.RespondentID = rs.RespondentID
            INNER JOIN sa_question q ON rs.QuestionID = q.QuestionID
            WHERE r.AssessmentID = :assessmentID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':assessmentID', $assessmentID);
    $stmt->execute();

    $results = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $questionID = $row['QuestionID'];

        if (!isset($results[$questionID])) {
            $results[$questionID] = [
                'QuestionID' => $questionID,
                'QuestionOrder' => $row['QuestionOrder'],
                'QuestionType' => $row['QuestionType'],
                'QuestionText' => $row['QuestionText'],
                'Service' => [],
                'Date' => [],
                'Choices' => [],
                'Ratings' => [],
                'Comments' => []
            ];
        }

        // Add data based on question type
        if ($row['QuestionType'] === 'Choice') {
            // Count choices
            $choices = explode(',', $row['Choices']);
            foreach ($choices as $choice) {
                // Check if choice key exists, then increment count, otherwise initialize count to 1
                $results[$questionID]['Choices'][$choice] = isset($results[$questionID]['Choices'][$choice]) ?
                    $results[$questionID]['Choices'][$choice] + 1 : 1;
            }
  
        } elseif ($row['QuestionType'] === 'Rate') {
            // Store rating
            $results[$questionID]['Ratings'][] = $row['Rating'];
            
        } elseif ($row['QuestionType'] === 'Ans') {
            // Store comment
            $results[$questionID]['Comments'][] = $row['Comment'];
        } elseif ($row['QuestionType'] === 'Service') {
            // Store comment
            $results[$questionID]['Service'][] = $row['Service'];
        
        } elseif ($row['QuestionType'] === 'Date') {
        // Store comment
       
        // Count choices
        $choices = explode(',', $row['Date']);
        foreach ($choices as $choice) {
            // Check if choice key exists, then increment count, otherwise initialize count to 1
            $results[$questionID]['Date'][$choice] = isset($results[$questionID]['Date'][$choice]) ?
                $results[$questionID]['Date'][$choice] + 1 : 1;
        }
        }
        
    }

    // Calculate average rating for each question
    foreach ($results as &$result) {
        if (!empty($result['Ratings'])) {
            $result['AverageRating'] = array_sum($result['Ratings']) / count($result['Ratings']);
        }
    }
    
    



    return $results;
}
?>