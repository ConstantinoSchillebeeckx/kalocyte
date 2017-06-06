<div class="container">

<?php
echo "<h1>API test of rspace.com</h1>";

if (isset($_GET["id"])) { // searching for a specific document

    $doc_dat = get_all_doc_dat($_GET["id"]);

    echo "<pre style='font-size:10px'>";
    print_r($doc_dat);
    echo "</pre>";

} else {

    $doc_names = get_doc_dat_by_key("name");

    echo "<h5>List of documents currently available:</h5>";
    echo "<ul>";
    foreach($doc_names as $id => $name) {
        $url = "?id=$id";
        echo "<li><a href='$url'>$name</a></li>";
    }
    echo "</ul>";

}

?>

</div>
