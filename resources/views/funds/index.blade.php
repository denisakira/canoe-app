<!DOCTYPE html>
<html>

<head>
    <title>Funds</title>
</head>

<body>
    <a href="/funds/create">Create</a>

    <h1>Funds</h1>

    <label for="nameFilter">Name</label>
    <input type="text" value="" id="nameFilter">

    <label for="yearFilter">Year</label>
    <input type="text" value="" id="yearFilter">

    <label for="fundManagerFilter">Fund Manager</label>
    <input type="text" value="" id="fundManagerFilter">

    <label>Fund Manager</label>

    <button id="filter">Filter</button>
    <ul>
        @foreach ($funds as $fund)
        <li>
            <a href="funds/{!! $fund->id !!}">
                {{ $fund->name }} - {{ $fund->start_year }} - {{ $fund->fundManager->name }} - {{ $fund->fundManager->id }}
                <br>
                @foreach ($fund->aliases as $alias)
                {{ $alias->name }} / 
                @endforeach

            </a>
        </li>
        @endforeach
    </ul>
</body>

<script>
    document.getElementById("filter").addEventListener("click", function() {
        const nameFilter = document.getElementById("nameFilter").value;
        const yearFilter = document.getElementById("yearFilter").value;
        const fundManagerFilter = document.getElementById("fundManagerFilter").value;
        window.location.href = "/funds?name=" + nameFilter + "&year=" + yearFilter + "&fundManager=" + fundManagerFilter;
    });
</script>

</html>