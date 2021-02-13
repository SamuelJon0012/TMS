<?php

if (!isset($_REQUEST['pw']) || (($_REQUEST['pw'] != 'yesterday') && $_REQUEST['pw'] != 'today')) {
    ?>
    <html>
    <body>
    <form action='/jabs.php' method='post'>

        <div style="text-align: center; margin-top:200px; width:100%;">
            <input type="password" name='pw' placeholder="What's the secret word?">
<!--            <br/>-->
<!--            <br/>-->
<!--            <input type="submit" value="download">-->
        </div>

    </form>
    </body>
    </html>
    <?php

    exit();

}

if ($_REQUEST['pw'] == 'today') {

    $DAY = 'current_date()';

} else {

    $DAY = "DATE_SUB(current_date(), INTERVAL 1 DAY)";

}


$conn = mysqli_connect(
    'database-1.c5ptxfpwznpr.us-east-1.rds.amazonaws.com',
    'admin',
    '4rfvBGT%6yhn',
    'tms'
);


$SQL = "

    select
        u.email,
           ifnull(v.room_name,'') as room_name,
           b.barcode,
           CONVERT_TZ(b.`timestamp`, '+00:00', '-05:00') as timestamp,
           p.name as provider,
           ifnull(v.status,0) as status

    from barcodes b
    left join users u on b.patient_id = u.id
    left join visits v on v.user_id = u.id
    left join users p on p.id = b.provider_id

    where

    CONVERT_TZ(b.`timestamp`, '+00:00', '-06:00') > $DAY

    group by b.patient_id
    order by b.timestamp;
";

$rows = mysqli_query($conn, $SQL);

// Keep phpstorm happy
$email = $room_name = $barcode = $timestamp = $provider = $status = 0;

$output = "email,room_name,barcode,timestamp,provider,status\n";

while ($row = mysqli_fetch_assoc($rows)) {

    extract($row); // dear god

    $barcode = explode('_',$barcode . '-')[0];

    $output .= "$email,$room_name,$barcode,$timestamp,$provider,$status\n";

}

$filename = 'work/' . uniqid() . '.csv';

file_put_contents($filename, $output);

header('Location: ' . $filename);
