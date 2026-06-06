<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Server Error — {{ config('app.name') }}</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f9fafb; color: #111827; margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .box { max-width: 420px; text-align: center; }
        .code { font-size: 4rem; font-weight: 800; color: #f97316; line-height: 1; }
        h1 { font-size: 1.5rem; margin: 1rem 0 0.5rem; }
        p { color: #6b7280; line-height: 1.6; }
        a { display: inline-block; margin-top: 1.5rem; padding: 0.625rem 1.25rem; background: #ea580c; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; }
    </style>
</head>
<body>
    <div class="box">
        <div class="code">500</div>
        <h1>Something went wrong</h1>
        <p>We hit an unexpected error. Please try again shortly.</p>
        <a href="/">Back to home</a>
    </div>
</body>
</html>
