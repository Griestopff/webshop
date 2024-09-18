<?php
// cookie consent field only showed if it isnt set or set to false
if(!isset($_COOKIE['cookie_consent']) || (isset($_COOKIE['cookie_consent']) && $_COOKIE['cookie_consent'] == "false")){
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/styles/cookie_consent.css">
    </head>
    <body>
        <div class="cookie-popup">
            <noscript>
                <div style="background-color: yellow; padding: 10px;">
                    Für die volle Funktionalität dieser Seite ist es notwendig, JavaScript zu aktivieren. Hier sind die <a href="https://www.enable-javascript.com/de/" target="_blank"> Anweisungen, wie Sie JavaScript in Ihrem Web-Browser aktivieren</a>.
                </div>
            </noscript>
            <h3>Cookie-Bestätigung</h3>
            <p>Diese Webseite verwendet notwendige und optionale Cookies, um deine Erfahrung zu verbessern. Bitte bestätige, dass du mit der Verwendung von Cookies einverstanden bist.</p>
            <button onclick="setCookieConsent(true)">Notwendige Cookies akzeptieren</button>
            <!--<button onclick="setCookieConsent(true)">Auch Optionale Cookies akzeptieren</button>-->
            <button onclick="setCookieConsent(false)">Keine Cookies Cookies akzeptieren</button>
        </div>

        <script>
            function setCookieConsent(consent) {
                // Setze den entsprechenden Cookie und lade die Seite neu
                document.cookie = "cookie_consent=" + consent + "; path=/";
                location.reload();
            }
        </script>
        <?php #include("/var/www/html/shop/htdocs/contents/frontpage.php");?>
    </body>
</html>
<?php
    // only show this field, if its shown, and don't load other code
    exit();
}