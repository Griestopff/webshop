<?php
    $userData = getUserDataById($userId);
    if(isset($_POST['emailReapeat'])){
        //TODO baseurl hinzufügen
        $link = '<a href="https://shxrt.de/index.php/register/code/'.$userData['registercode'].'">Anmeldung best&#228;tigen</a>';
        create_email("Rufen folgenden Link auf um deine Email zu best&#228;tigen:", $link, $userData['email'], NULL, "Email bestaetigen");
    }
#TODO delete user
?>
<div class="card">
                    <div class="card-header">
                        <h5>Benutzerprofil</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Benutzername:</strong> <?php echo($userData['user_name']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>E-Mail:</strong> <?php echo($userData['email']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Vorname:</strong> <?php echo($userData['first_name']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Nachname:</strong> <?php echo($userData['last_name']); ?>
                            </li>
                            <!-- Hier können weitere Benutzerinformationen hinzugefügt werden -->
                        </ul>
                        <?php
                            if(!userApproved($userId)){
                                echo("<div class='alert alert-danger text-center' role='alert'>
                                Dein Account ist noch nicht bestätigt!
                                <form method='post'>
                                    <button type='submit' name='emailReapeat' class='btn btn-primary'>Email erneut senden</button>
                                </form>
                                </div>");
                            }
                        ?>
                    </div>
                    <div class="card-footer">
                        <h5>Sonstiges</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Kleinere Card 1 -->
                                <div class="card">
                                    <div class="card-body">
                                    <form method="post">
                                        <?php $userDeleteCode = rand(0,100000);?>
                                        <input type="hidden" name="userDeleteCode" value="<?php echo($userDeleteCode);?>">
                                        <input type="hidden" name="userEmail" value="<?php echo($userData['email']);?>">
                                        <button type="userDelete" name="userDelete" class="btn btn-warning">Account löschen</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <!-- weitere cards -->
                        </div>
                    </div>
                </div>
            </div>
        
    <br>