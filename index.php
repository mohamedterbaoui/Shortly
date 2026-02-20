<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shortly – URL Shortener</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <div class="card">
    <h1>Shortly</h1>

    <form id="urlForm">
      <input
        type="url"
        name="long_url"
        placeholder="https://example.com"
        required
      >
      <button type="submit">Shorten URL</button>
    </form>

    <div id="result"></div>
  </div>

  <script src="assets/js/app.js"></script>
</body>
</html>