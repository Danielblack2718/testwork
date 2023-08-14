<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <Form action="http://127.0.0.1:8000/api/equipment" method="post">
        @csrf
        <select name="equipment_type_id">
            <option value="1">1</option>
        </select>
        <input type="text" name="serial_number">
        <input type="text" name="desc">
        <input type="submit">
    </Form>
</body>

<?php if(isset($_POST['name'])) echo $_POST['name'];?>
</html>
