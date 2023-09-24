<div class="container">
        <h2>User löschen</h2>
        <form method="post">
            <div class="form-group">
                <label for="deleteCode">Delete Code:</label>
                <input type="text" class="form-control" id="deleteCode" name="deleteCode" required>
                <small id="passwordInfo" class="form-text text-muted">
                    Du hast diesen Code per Email erhalten
                </small>
            </div>
            <div class="form-group">
                <label for="password">Passwort:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small id="passwordInfo" class="form-text text-muted">
                </small>
            </div>
            <button type="submit" name="delete" class="btn btn-primary">Account unwiderruflich mit allen Daten löschen</button>
        </form>
    </div>