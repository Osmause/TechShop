<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/pages/account.css">
    <title>Profile</title>
</head>

<body>
    <?php include('../includes/header.html'); ?>
    <main>
        <section>
            <div class="information">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                    <path
                        d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                </svg>
                <div class="container">
                    <div class="identity">
                        <span class="text-h2-media name">Doe</span>
                        <span class="text-h2-media name">John</span>
                    </div>

                    <div class="email-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                            <path
                                d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5z" />
                        </svg>
                        <span class="text-h2-media email">Example@techshop.com</span>
                    </div>

                    <div class="update-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M14 3v2H5v14h14v-9h2v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm5.94.354l.707.707a.5.5 0 0 1 0 .707L11.314 14.1l-1.992.98a.3.3 0 0 1-.402-.402l.98-1.992l9.333-9.333a.5.5 0 0 1 .707 0z" />
                        </svg>
                        <span class="text-h2-media update">Modifier les informations</span>
                    </div>
                </div>
            </div>
            <div class="grid">
                    <div class="security">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                    <path
                        d="M12 22q-3.475-.875-5.738-3.988T4 11.1V5l8-3l8 3v6.1q0 3.8-2.262 6.913T12 22m0-2.1q2.425-.75 4.05-2.963T17.95 12H12V4.125l-6 2.25v5.175q0 .175.05.45H12z" />
                </svg>
                <span class="text-h1-media">Securité</span>
            </div>
            <a class="order" href="../pages/orders.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M7.5 7v-.5a4.5 4.5 0 0 1 9 0V7H19c.552 0 1 .449 1 1.007v12.001c0 1.1-.895 1.992-1.994 1.992H5.994A1.994 1.994 0 0 1 4 20.008v-12C4 7.45 4.445 7 5 7zM9 7h6v-.5a3 3 0 0 0-6 0zM7.5 7v4H9V7zM15 7v4h1.5V7z" />
                </svg>
                <span class="text-h1-media">commandes</span>
            </a>
            <div class="invoice">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M19 21.5H6A3.5 3.5 0 0 1 2.5 18V4.943c0-1.067 1.056-1.744 1.985-1.422q.2.069.387.202l.175.125a2.51 2.51 0 0 0 2.912-.005a3.52 3.52 0 0 1 4.082 0a2.51 2.51 0 0 0 2.912.005l.175-.125c.993-.71 2.372 0 2.372 1.22V12.5H21a.75.75 0 0 1 .75.75v5.5A2.75 2.75 0 0 1 19 21.5M17.75 14v4.75a1.25 1.25 0 0 0 2.5 0V14zM13.5 9.75a.75.75 0 0 0-.75-.75h-6a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 .75-.75m-1 3a.75.75 0 0 0-.75-.75h-5a.75.75 0 1 0 0 1.5h5a.75.75 0 0 0 .75-.75m.25 2.25a.75.75 0 1 1 0 1.5h-6a.75.75 0 0 1 0-1.5z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-h1-media">Factures</span>
            </div>
            </div>
        </section>
    </main>
    <?php include('../includes/footer.html'); ?>
</body>
<script type="module" src="/assets/js/main.js"></script>

</html>