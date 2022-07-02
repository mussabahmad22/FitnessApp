<!DOCTYPE html>
<html>

<head>
    <title>Fitness App</title>
    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
        </style>
</head>

<body>
    <h1>User Booking Details</h1>
    <table>
        <thead>
            <tr>
                <th class="border-b-2 ">
                    Sr.</th>
                <th class="border-b-2 ">
                    Username</th>
                <th class="border-b-2  ">
                    Email</th>
                <th class="border-b-2  ">
                    Phone </th>
                <th class="border-b-2  ">
                    Type Session </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>
                    <?= $details->user_name ?>
                </td>
                <td>
                    <?= $details->user_email ?>
                </td>
                <td>
                    <?= $details->phone ?>
                </td>
                <td>
                    <?= $details->class_type ?>
                </td>
            </tr>
        </tbody>
    </table>


    <p>Thank you</p>
</body>

</html>