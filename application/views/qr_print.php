<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Print</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 10px;
        }

        form {
            margin: 30px;
            text-align: center;
        }

        .page {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: auto;
            gap: 0;
            page-break-after: always;
            padding: 10px;
        }

        .qr-box {
            text-align: center;
            padding: 10px 5px 5px 5px;
            margin: 0;
            page-break-inside: avoid;
            border-right: 1px dashed #aaa;
            border-bottom: 1px dashed #aaa;
        }

        .qr-box:nth-child(2n) {
            border-right: none;
        }

        .qr-box img {
            width: 150px;
            height: 150px;
            margin-bottom: 2px;
        }

        .member-name {
            margin-top: 0;
            font-size: 13px;
            font-weight: normal;
        }

        .last-page {
            page-break-after: auto;
        }
    </style>
</head>
<body>
    <?php
    $per_page = isset($per_page) ? (int)$per_page : 10;
    if (!isset($_GET['per_page'])):
    ?>
        <form method="get">
            <label style="font-size: 16px;">QRs per page:</label>
            <input type="number" name="per_page" value="10" min="1" max="50" required>
            <input type="submit" value="Start Print">
        </form>
    <?php else: ?>
        <script>window.onload = function() { window.print(); }</script>
        <?php
        $chunks = array_chunk($members, $per_page);
        foreach ($chunks as $index => $chunk):
        ?>
            <div class="page <?= ($index === count($chunks) - 1) ? 'last-page' : '' ?>">
                <?php foreach ($chunk as $member): ?>
                    <div class="qr-box">
                        <img src="<?= $member['qr'] ?>" alt="QR Code"><br>
                        <div class="member-name"><?= htmlspecialchars($member['name']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
