<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Send Message</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        th {
            cursor: pointer;
        }
    </style>
    <script src="js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <!--Top page div with information of the database connection-->
    <div align="center" class="alert alert-success">
        <?php
            echo 'Server Status:<br>';
            include "model/sqlserver_connection.php";
        ?>
    </div>
    <!--Form to send message-->
    <div align="center" id="form_sendmessage" class="container">
        <form action="controller/send.php" method="post">
            <table>
                <tr>
                    <td>To:</td><td><input type="tel" name="to" id="to" pattern="+[0-9]{3}[0-9]{4}[0-9]{4}" placeholder="+50312341234" required></td>
                </tr>
                <tr>
                    <td>Message:</td><td><textarea name="message" id="message" cols="30" rows="10" required maxlength="250"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><button type="submit" class="btn btn-success">Send Message</button></td>
                </tr>
            </table>
        </form>
    </div>
    <br><br>
    <!--List of sent messages-->
    <div id="table_sentmessages" align="center" class="container">
        <h3>Sent Messages</h3>
        <br><br>
        <table class="table">
            <thead>
                <tr>
                    <th>Created</th>
                    <th>To</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sqlselect = "SELECT * FROM dbo.message";
                    $result = sqlsrv_query($conn, $sqlselect);
                    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        echo '<tr>';
                            echo '<td>'.$row['created']->format('Y-m-d H:i:s').'</td>';
                            echo '<td>'.$row['to'].'</td>';
                            echo '<td>'.$row['message'].'</td>';
                        echo '<tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    <!--Script for order asc or desc the messages table-->
    <script>
        $('th').click(function(){
        var table = $(this).parents('table').eq(0)
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
        this.asc = !this.asc
        if (!this.asc){rows = rows.reverse()}
        for (var i = 0; i < rows.length; i++){table.append(rows[i])}
        })
        function comparer(index) {
            return function(a, b) {
                var valA = getCellValue(a, index), valB = getCellValue(b, index)
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
            }
        }
        function getCellValue(row, index){ return $(row).children('td').eq(index).text() }
    </script>
</body>
</html>