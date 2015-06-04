<?php
$html = file_get_contents('http://www.seismonepal.gov.np/index.php?action=earthquakes&show=recent'); //get the html returned from the following url

$data_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned

   $data_doc->loadHTML($html);
   libxml_clear_errors(); //remove errors for yucky html

   $data_xpath = new DOMXPath($data_doc);

   //get all the h2's with an id
   $data_row = $data_xpath->query('//td');

   if($data_row->length > 0){
       foreach($data_row as $row){
           echo $row->nodeValue . "<br/>";
       }
   }
   
}
?>
 