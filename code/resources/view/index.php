<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home work #5 - OTUS</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light" cz-shortcut-listen="true">
<div class="container">
    <main class="mt-4">
        <div class="row g-5">
            <div class="col-md-5 col-lg-4">
                <h4>Checkout form</h4>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-md-5 col-lg-4">
                <form action="/" method="POST">
                    <div class="mb-3">
                        <label for="brackets" class="form-label">brackets</label>
                        <input type="text" class="form-control" name="brackets" id="brackets" aria-describedby="bracketsHelp">
                        <div id="bracketsHelp" class="form-text">Enter the text view ((())))()()</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
