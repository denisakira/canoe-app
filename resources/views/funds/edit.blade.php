<!-- blade file with a form to create a fund -->
<!-- resources/views/create-funds.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Edit Fund</title>
</head>

<body>
    <a href="/funds">Index</a>

    <h1>Edit Fund</h1>
    <form action="/funds" method="PATCH">
        @csrf
        <input hidden="true" id="id" value="{!! $fund->id !!}">
        <label for="name">Name</label>
        <input type="text" name="name" value="{!! $fund->name !!}" id="name" />
        <label for="start_year">Start Year</label>
        <input type="text" name="start_year" value="{!! $fund->start_year !!}" id="start_year" />
        <label for="fund_manager_id">Fund Manager ID</label>
        <input type="text" name="fund_manager_id" value="{!! $fund->fundManager->name !!}" id="fund_manager_id" />
        <input type="button" id="submit" value="Submit" />
    </form>
</body>

<script>
    document.getElementById("submit").addEventListener("click", () => {
        const name = document.getElementById("name").value;
        const startYear = document.getElementById("start_year").value; 
        const fundManagerId = document.getElementById("fund_manager_id").value;

        const id = document.getElementById("id").value;

        fetch(`/api/funds/${id}`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify({
                name: name,
                start_year: startYear,
            })
        }).then(response => {
            console.log(response);
            window.location.href = "/funds";
        })
    });
</script>

</html>