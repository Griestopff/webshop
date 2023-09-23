<?php
if(strpos($route, '/register/code') !== false){
            
    //get the register code from the route
    $explod_array = explode('/register/code',$route);
    $route = '/register/code'.$explod_array[1];
    $routeParts = explode('/',$route);
    $registerCode = $routeParts[3];

    //checks if the user registered and isnt approved
    if(confirmUserWithRegisterCode($registerCode)){
        echo("<div class='alert alert-success text-center' role='alert'>
                            Bestätigung erfolgreich!
                            </div>");
    }else{
        echo("<div class='alert alert-danger text-center' role='alert'>
                            Bestätigung war nicht erfolgreich!
                            </div>");
    }
       
        }else{  
?>
<div class="container">
    <h2>Registrierung</h2>
    <form method="post">
        <div class="form-group">
            <label for="username">Benutzername:</label>
            <input type="text" class="form-control" id="username" name="username" required>
            <small id="passwordInfo" class="form-text text-muted">
                Erlaubte Zeichen: Buchstaben (Groß- und Kleinbuchstaben), Zahlen und Umlaute
            </small>
        </div>
        <div class="form-group">
            <label for="first_name">Vorname:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
            <small id="passwordInfo" class="form-text text-muted">
                Erlaubte Zeichen: Buchstaben (Groß- und Kleinbuchstaben), Zahlen, Umlaute und Leerzeichen für Doppelnamen
            </small>
        </div>
        <div class="form-group">
            <label for="last_name">Nachname:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
            <small id="passwordInfo" class="form-text text-muted">
                Erlaubte Zeichen: Buchstaben (Groß- und Kleinbuchstaben), Zahlen, Umlaute und Leerzeichen für Doppelnamen
            </small>
        </div>
        <div class="form-group">
            <label for="email">E-Mail-Adresse:</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <small id="passwordInfo" class="form-text text-muted">
                Muss mindestens ein @ und einn . enthalten
            </small>
        </div>
        <div class="form-group">
            <label for="emailRepeat">E-Mail-Adresse bestätigen:</label>
            <input type="email" class="form-control" id="emailRepeat" name="emailRepeat" required>
            <small id="passwordInfo" class="form-text text-muted">
                Muss mindestens ein @ und einn . enthalten
            </small>
        </div>
        <div class="form-group">
            <label for="password">Passwort:</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <small id="passwordInfo" class="form-text text-muted">
                Erlaubte Zeichen: Buchstaben (Groß- und Kleinbuchstaben), Zahlen und Sonderzeichen !@#$%&*()
            </small>
        </div>
        <div class="form-group">
            <label for="confirm_password">Passwort bestätigen:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            <small id="passwordInfo" class="form-text text-muted">
                Erlaubte Zeichen: Buchstaben (Groß- und Kleinbuchstaben), Zahlen und Sonderzeichen !@#$%&*()
            </small>
        </div>
        <button type="submit" class="btn btn-primary">Registrieren</button>
    </form>
</div>
<?php
        }
?>