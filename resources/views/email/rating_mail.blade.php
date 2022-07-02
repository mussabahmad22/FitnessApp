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

        td,
        th {
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
    <h1>Rating By User</h1>
    <table>
        <thead>
            <tr>
                <th class="border-b-2 ">
                    Sr.</th>
                <th class="border-b-2 ">
                    Username</th>
                <th class="border-b-2 ">
                    Class Name</th>
                <th class="border-b-2  ">
                    Class Review</th>
                <th class="border-b-2  ">
                    Difficulty Rating </th>
                <th class="border-b-2  ">
                    Instructor Rating </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>
                    <?= $user_name['name'] ?>
                </td>
                <td>
                    <?= $class_name['clas_name'] ?>
                </td>
                <td>
                    <?= $details->class_review	?>
                </td>
                <td>
                    <?= $details->difficulty_rating ?> star
                </td>
                <td>
                    <?= $details->instructor_rating ?> star
                </td>
            </tr>
        </tbody>
    </table>


    <p>Thank you</p>
</body>

</html>