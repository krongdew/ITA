<?php

include 'connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function getAssessmentResults($assessmentID, $startDate = null, $endDate = null)
{
    global $conn;

    try {
        $sql = "SELECT resp.RespondentID, 
                       j.QuestionID,
                       j.QuestionType,
                       j.Answer,
                       q.QuestionOrder, 
                       q.QuestionText,
                       ss.subservice_name
                FROM sa_respondent r
                INNER JOIN sa_response2 resp ON r.RespondentID = resp.RespondentID
                CROSS JOIN JSON_TABLE(
                    resp.Responses,
                    '$[*]' COLUMNS(
                        QuestionID INT PATH '$.QuestionID',
                        QuestionType VARCHAR(50) PATH '$.QuestionType',
                        Answer JSON PATH '$.Answer'
                    )
                ) AS j
                INNER JOIN sa_question q ON j.QuestionID = q.QuestionID
                LEFT JOIN sa_subservices ss ON j.Answer = ss.ID
                WHERE r.AssessmentID = :assessmentID";

        if ($startDate && $endDate) {
            $sql .= " AND JSON_UNQUOTE(JSON_EXTRACT(resp.Responses, '$[1].Answer')) BETWEEN :startDate AND :endDate";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':assessmentID', $assessmentID, PDO::PARAM_INT);

        if ($startDate && $endDate) {
            $stmt->bindParam(':startDate', $startDate);
            $stmt->bindParam(':endDate', $endDate);
        }

        $stmt->execute();


        $results = [];
        $totalRespondents = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $questionID = $row['QuestionID'];
            $answer = json_decode($row['Answer'], true);
            $subserviceName = $row['subservice_name']; // Get subservice_name
         


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
                    'Subservice' => [],
                    'Comments' => [],
                    'TotalResponses' => 0
                ];
            }

            $results[$questionID]['TotalResponses']++;
            $totalRespondents++;

            switch ($row['QuestionType']) {
                case 'Choice':
                    if (is_array($answer)) {
                        foreach ($answer as $choice) {
                            $results[$questionID]['Choices'][$choice] = isset($results[$questionID]['Choices'][$choice]) ?
                                $results[$questionID]['Choices'][$choice] + 1 : 1;
                        }
                    } elseif (is_string($answer)) {
                        $results[$questionID]['Choices'][$answer] = isset($results[$questionID]['Choices'][$answer]) ?
                            $results[$questionID]['Choices'][$answer] + 1 : 1;
                    }
                    break;
                case 'Rate':
                    if (is_numeric($answer)) {
                        $results[$questionID]['Ratings'][] = $answer;
                    }
                    break;
                case 'Subservice':
                    
                        $answerValue = is_array($answer) ? json_encode($answer) : $answer;
                        if ($subserviceName) {
                            $results[$questionID]['Subservice'][$subserviceName] = isset($results[$questionID]['Subservice'][$subserviceName]) ?
                                $results[$questionID]['Subservice'][$subserviceName] + 1 : 1;
                        } else {
                            // เก็บค่า Answer ไว้ในกรณีที่ไม่มี subservice_name
                            $results[$questionID]['Subservice'][$answerValue] = isset($results[$questionID]['Subservice'][$answerValue]) ?
                                $results[$questionID]['Subservice'][$answerValue] + 1 : 1;
                        }
                        break;
                    
                    break;
                case 'Ans':
                    if (is_string($answer)) {
                        $results[$questionID]['Comments'][] = $answer;
                    }
                    break;
                case 'Service':
                    if (is_string($answer)) {
                        $results[$questionID]['Service'][] = $answer;
                    }
                    break;
                case 'Date':
                    if (is_string($answer)) {
                        $results[$questionID]['Date'][$answer] = isset($results[$questionID]['Date'][$answer]) ?
                            $results[$questionID]['Date'][$answer] + 1 : 1;
                    }
                    break;
            }
        }

        // คำนวณเปอร์เซ็นต์สำหรับ Choice
        foreach ($results as &$result) {
            if ($result['QuestionType'] === 'Choice') {
                foreach ($result['Choices'] as $choice => $count) {
                    $result['Choices'][$choice] = [
                        'count' => $count,
                        'percentage' => ($count / $result['TotalResponses']) * 100
                    ];
                }
            }
        }

        if (empty($results)) {
            return array(); // ส่งคืน array ว่างถ้าไม่มีผลลัพธ์
        }

        return $results;
    } catch (PDOException $e) {
        error_log("Database Error in getAssessmentResults: " . $e->getMessage());
        return array('error' => "An error occurred while fetching the data: " . $e->getMessage());
    } catch (Exception $e) {
        error_log("General Error in getAssessmentResults: " . $e->getMessage());
        return array('error' => "An unexpected error occurred: " . $e->getMessage());
    }
}
