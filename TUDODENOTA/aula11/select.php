<?php
$conn = pg_connect("host=localhost dbname=aula11 user=postgres password=1234");

$sql = "SELECT * FROM TBPESSOA";
$result = pg_query($conn, $sql);

while ($row = pg_fetch_assoc($result)) {
    echo $row['pescodigo'] . " - " . $row['pesnome'] . "<br>";
}
?>
