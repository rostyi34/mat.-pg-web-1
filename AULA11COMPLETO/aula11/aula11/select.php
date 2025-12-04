<?php
$conn = pg_connect("host=localhost dbname=postgres user=postgres password=123");

$sql = "SELECT * FROM TBPESSOA";
$result = pg_query($conn, $sql);

while ($row = pg_fetch_assoc($result)) {
    echo $row['pescodigo'] . " - " . $row['pesnome'] . "<br>";
}
?>
