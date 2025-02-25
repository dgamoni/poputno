<?php
function get_abbyy_cloud_ocr()
{
// 1. Send image to Cloud OCR SDK using processImage call
// 2.	Get response as xml
// 3.	Read taskId from xml

//!!! Please provide your application id and password and remove this line !!!
    // To create an application and obtain a password,
    // register at http://cloud.ocrsdk.com/Account/Register
    // Name of application you created

    $applicationId = 'Google scaning feedburner counter followers';
    // Password should be sent to your e-mail after application was created
    $password = 'Yu+hrYAhu/lS19wsyFqPGv1Z';
    $fileName = 'ain.png';

    // Get path to file that we are going to recognize
    $local_directory = dirname(__FILE__) . '/images';
    $local_file_log = dirname(__FILE__) . '/log/work.log';
    $filePath = $local_directory . '/' . $fileName;

    file_put_contents($filePath, file_get_contents('http://feeds.feedburner.com/~fc/ainua'));

    //file_put_contents($local_file_log, 'test');

    if (!file_exists($filePath)) {
        //die('File ' . $filePath . ' not found.');
        file_put_contents($local_file_log, 'File ' . $filePath . ' not found.');
        return '';
    }
    if (!is_readable($filePath)) {
        //die('Access to file ' . $filePath . ' denied.');
        file_put_contents($local_file_log, 'Access to file ' . $filePath . ' denied.');
        return '';
    }

    // Recognizing with English language to rtf
    // You can use combination of languages like ?language=english,russian or
    // ?language=english,french,dutch
    // For details, see API reference for processImage method
    $url = 'http://cloud.ocrsdk.com/processImage?language=english&exportFormat=txt';

    // Send HTTP POST request and ret xml response
    $curlHandle = curl_init();
    curl_setopt($curlHandle, CURLOPT_URL, $url);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
    curl_setopt($curlHandle, CURLOPT_POST, 1);
    curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
    $post_array = array(
        "my_file" => "@" . $filePath,
    );
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post_array);
    $response = curl_exec($curlHandle);
    if ($response == FALSE) {
        $errorText = curl_error($curlHandle);
        curl_close($curlHandle);
        die($errorText);
    }
    $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
    curl_close($curlHandle);

    // Parse xml response
    $xml = simplexml_load_string($response);
    if ($httpCode != 200) {
        if (property_exists($xml, "message")) {
            //die($xml->message);
            file_put_contents($local_file_log, '$xml->message=' . $xml->message);
            return '';

        }
        //die("unexpected response " . $response);
        file_put_contents($local_file_log, "unexpected response " . $response);
        return '';

    }

    $arr = $xml->task[0]->attributes();
    $taskStatus = $arr["status"];
    if ($taskStatus != "Queued") {
        //die("Unexpected task status " . $taskStatus);
        file_put_contents($local_file_log, "Unexpected task status " . $taskStatus);
        return '';
    }

    // Task id
    $taskid = $arr["id"];

    // 4. Get task information in a loop until task processing finishes
    // 5. If response contains "Completed" staus - extract url with result
    // 6. Download recognition result (text) and display it

    $url = 'http://cloud.ocrsdk.com/getTaskStatus';
    $qry_str = "?taskid=$taskid";

    // Check task status in a loop until it is finished
    // TODO: support states indicating error
    while (true) {
        sleep(5);
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url . $qry_str);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
        curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
        $response = curl_exec($curlHandle);
        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);

        // parse xml
        $xml = simplexml_load_string($response);
        if ($httpCode != 200) {
            if (property_exists($xml, "message")) {
                die($xml->message);
            }
            die("Unexpected response " . $response);
        }
        $arr = $xml->task[0]->attributes();
        $taskStatus = $arr["status"];
        if ($taskStatus == "Queued" || $taskStatus == "InProgress") {
            // continue waiting
            continue;
        }
        if ($taskStatus == "Completed") {
            // exit this loop and proceed to handling the result
            break;
        }
        if ($taskStatus == "ProcessingFailed") {
            die("Task processing failed: " . $arr["error"]);
        }
        die("Unexpected task status " . $taskStatus);
    }

    // Result is ready. Download it
    /*
        $url = $arr["resultUrl"];
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        // Warning! This is for easier out-of-the box usage of the sample only.
        // The URL to the result has https:// prefix, so SSL is required to
        // download from it. For whatever reason PHP runtime fails to perform
        // a request unless SSL certificate verification is off.
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curlHandle);
        curl_close($curlHandle);
    */
    // Let user donwload rtf result
    //header('Content-type: application/rtf');
    //header('Content-Disposition: attachment; filename="file.rtf"');
    return preg_replace('~[^0-9]+~', '', file_get_contents($arr["resultUrl"]));
}