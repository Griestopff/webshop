<br>
<?php
if(strpos($route, '/resetpassword/code') !== false){            
    //get the register code from the route
    #$explod_array = explode('/resetpassword/code',$route);
    #$route = '/resetpassword/code'.$explod_array[1];
    #$routeParts = explode('/',$route);
    #$resetCode = $routeParts[3];

    if(isset($_POST['submit'])){
        //checks if the passwort contains not allowed characters
        $password = checkPassword($_POST['password']);
        $passwordConfirm = checkPassword($_POST['confirm_password']);
        $resetCode = $_POST['resetcode'];
        //checks if given resetcode is correct
        if(userHasResetCode($resetCode)){
            if($password == $passwordConfirm){
                //checks if password contains illegal chars (from checkPassword-Method)
                if($password !== false){
                    if(updateUserPassword(getUserIdByResetCode($resetCode), $password)){
                        echo("<div class='alert alert-success text-center' role='alert'>
                        Dein Passwort wurde erfolgreich geändert!
                        </div>");
                    }
                }else{
                    echo("<div class='alert alert-danger text-center' role='alert'>
                    Dein neues Passwört enthält nicht erlaubte zeichen!
                    </div>");
                }
            }else{
                echo("<div class='alert alert-danger text-center' role='alert'>
                    Deine Passwörter stimmen nicht überein!
                    </div>");
            }
        }else{
            echo("<div class='alert alert-danger text-center' role='alert'>
            Dein ResetCode ist falsch!
            </div>");
        }
        

    }
?>
    <div class="container">
        <h2>Passwort setzen</h2>
        <form method="post">
            <div class="form-group">
                <label for="resetcode">Reset Code:</label>
                <input type="text" class="form-control" id="resetcode" name="resetcode" required>
                <small id="passwordInfo" class="form-text text-muted">
                    Du hast diesen Code per Email erhalten
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
            <button type="submit" name="submit" class="btn btn-primary">Passwort setzen</button>
        </form>
    </div>
<?php
//sending email to user
}else{ 
        if(isset($_POST['email']) && $_POST['email'] !== NULL && $_POST['email'] !== ''){
            //checks if there is a user with this email
            if(checkEmail($_POST['email'])){
                $randomCode = rand(0,100000);
                //checks if insert was correct
                if(insertResetCode($_POST['email'], $randomCode)){
                    //TODO
                    $link = 'Dein Code ist '.$randomCode.' <a href="http://www.shxrt.de/index.php/resetpassword/code">Passwort Reset</a>';
                    create_email("Rufen Sie folgenden Link auf um dein Password zu setzen:", $link, $_POST['email'], NULL, "Passwort Reset");
                    echo("<div class='alert alert-success text-center' role='alert'>
                        Du hast eine Email erhalten!
                        </div>");
                }else{
                    echo("<div class='alert alert-danger text-center' role='alert'>
                        Es ist ein Fehler aufgetreten!
                        </div>");
                }
            }else{
                echo("<div class='alert alert-danger text-center' role='alert'>
                    Diese Email ist nicht vorhanden!
                    </div>");
            }
            
        } 
?>
    <div class="container">
        <form method="post">
            <div class="form-group">
                <label for="email">E-Mail-Adresse:</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <small id="passwordInfo" class="form-text text-muted">
                    Gib die Email deines Kontos an.
                </small>
            </div>
            <div class="row">
            <button type="submit" class="btn btn-warning">Email senden</button>
            </div>
        </form>
    </div>
<?php
}
?>
<br>


