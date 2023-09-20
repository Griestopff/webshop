import os

# Funktion zum Durchsuchen einer Datei nach TODO-Kommentaren
def suche_todo_in_datei(dateipfad):
    with open(dateipfad, "rb") as datei:
        zeilen = datei.readlines()
        for nummer, rohe_zeile in enumerate(zeilen, start=1):
            try:
                zeile = rohe_zeile.decode("utf-8")
                #nicht "// TODO" -> das kommt in Bootstrap vor
                if "#TODO" in zeile or "# TODO" in zeile or "//TODO" in zeile or "// TODO" in zeile:
                    print(f"In Datei: {dateipfad}, Zeile {nummer}: {zeile.strip()}")
            except UnicodeDecodeError:
                print(f"Fehler beim Lesen von Datei: {dateipfad}, Zeile {nummer}: Nicht decodierbare Zeile")

# Funktion zum Durchsuchen eines Verzeichnisses
def suche_todo_in_verzeichnis(verzeichnis):
    for verzeichnisname, _, dateien in os.walk(verzeichnis):
        if (("./styles/bootstrap" in verzeichnisname) or ("./.git" in verzeichnisname)):
            continue  # Ignoriere das Verzeichnis ./styles/bootstrap
        for datei in dateien:
            dateipfad = os.path.join(verzeichnisname, datei)
            if (("./search_for_todos.py" in dateipfad) or ("./.gitignore" in dateipfad)):
            	continue
            suche_todo_in_datei(dateipfad)

if __name__ == "__main__":
    # Hier kannst du das Verzeichnis festlegen, das du durchsuchen möchtest
    verzeichnis = "."  # Aktuelles Verzeichnis

    suche_todo_in_verzeichnis(verzeichnis)
