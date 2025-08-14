<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR - <?= htmlspecialchars($name) ?></title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 10px;
        }

        .page {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: auto;
            gap: 0;
            padding: 10px;
        }

        .qr-box {
            text-align: center;
            padding: 10px 5px;
            border-right: 1px dashed #aaa;
            border-bottom: 1px dashed #aaa;
            height: 240px; /* fixed height per slot */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .qr-box:nth-child(2n) {
            border-right: none;
        }

        .qr-box img {
            width: 150px;
            height: 150px;
            margin: 0 auto 4px;
        }

        .member-name {
            font-size: 13px;
            margin: 0;
        }

        .empty-slot {
            visibility: hidden;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page">
        <!-- Only 1 slot filled -->
        <div class="qr-box">
            <img src="<?= $qr ?>" alt="QR Code">
            <div class="member-name"><?= htmlspecialchars($name) ?></div>
        </div>

        <!-- 9 empty placeholders -->
        <?php for ($i = 1; $i < 10; $i++): ?>
            <div class="qr-box empty-slot">
                <img src="<?= $qr ?>" alt="QR Code">
                <div class="member-name"><?= htmlspecialchars($name) ?></div>
            </div>
        <?php endfor; ?>
    </div>
</body>
</html>
