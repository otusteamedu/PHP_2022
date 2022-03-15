<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home work #6 - OTUS</title>

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
                <h4>Validation email</h4>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-md-5 col-lg-4">
                <form action="/" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Input email" aria-describedby="email">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <?php if(session()->alertMessage()->has('success') || session()->alertMessage()->has('error')): ?>
            <div class="row g-5">
                <div class="col-md-5 col-lg-4 pt-4">
                    <?php session()->alertMessage()->allFlash(); ?>
                </div>
            </div>
        <?php endif; ?>
    </main>
</div>
</body>
</html>
