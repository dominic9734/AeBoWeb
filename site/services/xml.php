<?php
/*
File Name: xml.php
Project: aeboWeb
Description: Generates an XML file containing book sources based on user input
Author: D.Leuthardt
Parameters:
XmlSelection (IN) - User input via HTTP POST request as JSON
Returns: None
Modification History:

Purpose:
This function creates XML files with book sources based on user input using an SQL query to retrieve data from a database. 
The resulting XML file is sent as an attachment in a HTTP response with appropriate headers.
*/

$xmlSelections = ($_POST['XmlSelection']);

$array = json_decode($xmlSelections);

// Initialize an empty array to hold the WHERE clauses
$where_clauses = array();

// Iterate over the values in the array
foreach ($array as $value) {
    // Add a WHERE clause for each value to the array of WHERE clauses, with the % symbol next to the LIKE keyword
    $where_clauses[] = "book_number LIKE '$value.%'";
}

// Implode the array of WHERE clauses with the OR operator
$where_clause_string = implode(' OR ', $where_clauses);

// Use the WHERE clause string to generate the final SQL statement
$sql = "SELECT * FROM lib_books WHERE $where_clause_string";


$domtree = new DOMDocument('1.0', 'UTF-8');
$domtree->encoding = 'utf-8';
$xmlRoot = $domtree->createElement("b:Sources");
$xmlRoot = $domtree->appendChild($xmlRoot);

$SelectedStyle = $domtree->createAttribute('SelectedStyle');
$SelectedStyle->value = '';
$xmlRoot->appendChild($SelectedStyle);
$domtree->appendChild($xmlRoot);

$xmlnsb = $domtree->createAttribute('xmlns:b');
$xmlnsb->value = 'http://schemas.openxmlformats.org/officeDocument/2006/bibliography';
$xmlRoot->appendChild($xmlnsb);
$domtree->appendChild($xmlRoot);



$xmlns = $domtree->createAttribute('xmlns');
$xmlns->value = 'http://schemas.openxmlformats.org/officeDocument/2006/bibliography';
$xmlRoot->appendChild($xmlns);
$domtree->appendChild($xmlRoot);

include "../../site/services/db_connect.php";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

if ($result->num_rows != 0) {
    while ($row = $result->fetch_assoc()) {

        $val_author = $row['book_autor'];
        $val_title = $row['book_title'];
        $val_year = $row['book_edition'];
        $val_numb = $row['book_number'];

        $Source = $domtree->createElement("b:Source");
        $Source = $xmlRoot->appendChild($Source);
        $Source->appendChild($domtree->createElement('b:Tag', htmlspecialchars($val_numb)));
        $Source->appendChild($domtree->createElement('b:SourceType', 'Book'));

        $Author = $Source->appendChild($domtree->createElement('b:Author'));
        $SubAuthor = $Author->appendChild($domtree->createElement('b:Author'));
        $NameList = $SubAuthor->appendChild($domtree->createElement('b:NameList'));
        $Person = $NameList->appendChild($domtree->createElement('b:Person'));
        $Person->appendChild($domtree->createElement('b:First', htmlspecialchars($val_author)));
        $Person->appendChild($domtree->createElement('b:Last', ''));

        $Source->appendChild($domtree->createElement('b:Title', htmlspecialchars($val_title)));
        $Source->appendChild($domtree->createElement('b:Year', htmlspecialchars($val_year)));
        $Source->appendChild($domtree->createElement('b:City', ''));
        $Source->appendChild($domtree->createElement('b:Publisher', ''));
    }
}

ob_end_clean();
header_remove();

header("Content-type: text/xml");
header('Content-Disposition: attachment; filename="Sources_AEBO_' . date("d_m_Y") . '.xml"');

echo $domtree->saveXML();
