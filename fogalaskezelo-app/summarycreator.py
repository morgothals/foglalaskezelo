from pathlib import Path


def main():
    script_dir = Path(__file__).resolve().parent
    summary_file = script_dir / "summary.txt"

    # Kizárandó nevek (fájl vagy mappa)
    excluded_names = {
        ".git",
        ".github",
        "bootstrap",
        "database.sqlite",
        "node_modules",
        "public",
        "storage",
        "vendor",
        ".editorconfig",
        ".env",
        ".env.example",
        "artisan",
        "composer.json",
        "composer.lock",
        "LICENSE",
        "phpunit.xml",
        "vite.config.js",



        ".gitignore",  # git fájl
        ".gitattributes",
        "LICENSE",     # licenc fájl
        "venv",        # virtuális környezet mappa
        "__pycache__", # Python cache mappa
        "summary.txt", # kimeneti fájl
        "summarycreator.py", # saját fájl
    }

    with summary_file.open("w", encoding="utf-8") as out:
        for path in script_dir.rglob("*"):
            # Kizárjuk, ha bármelyik mappanév vagy a fájlneve szerepel az excl. listában
            if any(part in excluded_names for part in path.parts):
                continue

            if path.is_file():
                rel_path = path.relative_to(script_dir)
                out.write(f"{rel_path} tartalma:\n")
                try:
                    content = path.read_text(encoding="utf-8")
                    out.write(content)
                except Exception as e:
                    out.write(f"<Nem olvasható: {e}>\n")
                out.write("\n\n")

if __name__ == "__main__":
    main()
