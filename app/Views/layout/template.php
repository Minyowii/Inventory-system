<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #D9DDDC; font-family: 'Segoe UI', sans-serif; }
        .card { border-radius: 15px; border: none; }
        .btn-custom { background-color: #1976D2; color: white; border: none; }
        .btn-custom:hover { background-color: #1565C0; color: white; }
        .action-icon { font-size: 1.1rem; text-decoration: none; margin: 0 5px; }
        .text-view { color: #6f42c1; }
        .text-edit { color: #1976D2; }
        .text-delete { color: #dc3545; }
    </style>
</head>
<body>
    <?= $this->renderSection('content') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>