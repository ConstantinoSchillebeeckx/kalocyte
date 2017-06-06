<?php

/**
 * Execute a curl call on the given URL using that
 * API key generated for Rspace
 *
 * @param (str) $url - url to call with curl see https://community.researchspace.com/public/apiDocs
 * @param (str) $type - type of response to accept, must be one of json or csv. default is JSON
 *
 * @return (assoc arr) - json decoded response of API call
 */
function exec_curl($url, $type = 'json') {

    if ($type != 'json' && $type != 'csv') return;

    // to request a CSV, can simply append .csv to the url
    if ($type == 'csv') $url .= '.csv';

    require_once('config/db.php');

    //  Initiate curl
    $ch = curl_init();

    // Set options
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // disable SSL verification
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json')); // json accept type
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('apiKey: ' . API_KEY)); // set API key loaded by config/db.php
    curl_setopt($ch, CURLOPT_URL, $url); // API url

    // Execute & close
    $result=curl_exec($ch);
    curl_close($ch);

    if ($type == 'json') {
        return json_decode($result, true);
    } else if ($type == 'csv') {
        return $result;
    }

}

/**
 * Query Rspace for a list of documents and return
 * the value specified by "key" for that document.
 *
 * @param (str) $key - the document data key to lookup and return, see API docs
 *                     for a list of possible keys. defaults to "id"
 * @param (str) $url - API url to call, defaults
 *                     to query all documents with a pagesize of 50
 *
 * @return (assoc arr) - keys are document ids and the values are the values
 *                       assigned to the document key. if the specified input $key 
 *                       doesn't exist in the return data, a null value is stored.
 *                       if no results are found, an empty array is returned.
 */
function get_doc_dat_by_key($key = "id", $url=null) {

    if ($url == null) $url = "https://community.researchspace.com/api/v1/documents?pageSize=50";

/*
    $url .= encodeURIComponent(JSON.stringify('&advancedQuery={ "operator: "or", 
  "terms": [ {"query": "IMAC", "queryType": "fullText"}, 
             {"query": "TFF", "queryType": "name" }] }'));
*/

    $curl = exec_curl($url);

    $docs = array();
    if (isset($curl["totalHits"]) and $curl["totalHits"] > 0) { // if there are more than 0 results
        foreach($curl["documents"] as $doc) {
            $id = $doc["id"];
            $docs[$id] = in_array($key, array_keys($doc)) ? $doc[$key] : null; 
        }
    }

    return $docs;

}



function get_all_doc_dat($id) {

    if (!isset($id) && is_int($id)) {
        return false;
    }

    $url = "https://community.researchspace.com/api/v1/documents/$id";

    return exec_curl($url, 'csv');


}



?>
