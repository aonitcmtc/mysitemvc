<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Admin') ?></title>
    <!-- css here -->
</head>
<body>

    <!-- Sidebar here (same as above) -->

    <div class="main-content">
        <!-- Top bar -->
        
        <main>
            <?= $content ?? '' ?>
        </main>
    </div>

    <!-- scripts -->
</body>
</html>