<?php
    $userData = getUserDataById($userId);
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
                    </div>
                    <div class="card-footer">
                        <h5>Sonstiges</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Kleinere Card 1 -->
                                <div class="card">
                                    <div class="card-body">
                                        Inhalt der ersten kleinen Card
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Kleinere Card 2 -->
                                <div class="card">
                                    <div class="card-body">
                                        Inhalt der zweiten kleinen Card
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Kleinere Card 3 -->
                                <div class="card">
                                    <div class="card-body">
                                        Inhalt der dritten kleinen Card
                                    </div>
                                </div>
                            </div>
                            <!-- weitere cards -->
                            <?php
                            #foreach
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        
    <br>