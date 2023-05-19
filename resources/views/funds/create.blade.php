<!-- blade file with a form to create a fund -->
<!-- resources/views/create-funds.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Create Fund</title>
</head>

<body>
    <a href="/funds">Index</a>

    <h1>Create Fund</h1>
    <form action="/funds" method="POST">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" id="name" />

        <label for="start_year">Start Year</label>
        <input type="text" name="start_year" id="start_year" />

        <select id="fundManagerId">
            @foreach ($fundManagers as $fundManager)
            <option value="{!! $fundManager->id !!}">{!! $fundManager->name !!}</option>
            @endforeach
        </select>

        <label for="alias">Add alias</label>
        <input type="button" name="alias" id="alias" value="Alias">

        <div id="aliases"></div>

        <input type="button" id="submit" value="Submit" />
    </form>
</body>

<script>

    document.getElementById("alias").addEventListener("click", () => {
        const aliasDiv = document.getElementById("aliases");

        const input = document.createElement("input");
        input.type = "text";
        input.name = "alias[]";

        aliasDiv.appendChild(input);

        const br = document.createElement("br");

        aliasDiv.appendChild(br);
    });

    document.getElementById("submit").addEventListener("click", () => {
        const name = document.getElementById("name").value;
        const startYear = document.getElementById("start_year").value;
        const fundManagerId = document.getElementById("fundManagerId").value;

        const aliases = [];

        document.getElementsByName("alias[]").forEach(alias => {
            aliases.push(alias.value);
        });

        fetch(`/api/funds`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify({
                name: name,
                start_year: startYear,
                fund_manager_id: fundManagerId,
                aliases,
            })
        }).then(response => {
            console.log(response);
        })
    });
</script>

</html>