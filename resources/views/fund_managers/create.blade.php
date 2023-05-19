<!-- create file for creating a fund manager -->
<!-- resources/views/create-fund-manager.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Create Fund Manager</title>
</head>

<body>
    <h1>Create Fund Manager</h1>
    <form action="/fund-managers" method="POST">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" id="name" />
        <input type="submit" value="Submit" />
    </form>
</body>

</html>