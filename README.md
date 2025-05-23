# Fodrászati foglaláskezelő weboldal Laravel keretrendszerrel

## Készítette:
- Borbás Péter

Emailek:
- storage/logs/ külön napi mentésben


# 🚀 Laravel Telepítési Útmutató, hogy ne legyél te is béna

## Előkészületek

- Győződj meg róla, hogy telepítve van:
  - PHP (>=8.1)
  - Composer
  - Node.js + npm
  - Git

## Telepítés lépések

1. **Projekt klónozása vagy létrehozása**

   ```bash
   git clone <repository-url>
   cd projekt-neve
   ```

   vagy

   ```bash
   composer create-project laravel/laravel projekt-neve
   cd projekt-neve
   ```

2. **Composer függőségek telepítése**

   ```bash
   composer install
   ```

3. **NPM csomagok telepítése**

   ```bash
   npm install
   ```

4. **PHP beállítása**
   - Ellenőrizd a PHP elérési útját:

     ```bash
     Get-Command php
     ```

   - Ha nincs `php.ini`:
     - Másold a `php.ini-development` vagy `php.ini-production` fájlt `php.ini` néven.
   - **Kötelezően engedélyezendő extensionök a `php.ini`-ben** (töröld előlük a `;` karaktert):

     ```
     extension=fileinfo
     extension=openssl
     extension=pdo
     extension=mbstring
     extension=mysqli (vagy sqlite3, ha SQLite adatbázist használsz)
     ```

   - **Módosítsd a `variables_order` értéket, ha nem tudja elindítani a szervert a php artisan serve parancs:**
     - Keresd meg:

       ```ini
       variables_order = "EGPCS"
       ```

     - Írd át erre:

       ```ini
       variables_order = "GPCS"
       ```

5. **.env fájl létrehozása és konfigurálása**

   ```bash
   cp .env.example .env
   ```

6. **APP KEY generálás**

   ```bash
   php artisan key:generate
   ```

7. **Adatbázis beállítása**
   - SQLite használata esetén:
     - Hozz létre egy üres fájlt:

       ```bash
       touch database/database.sqlite
       ```

     - `.env` fájlban állítsd be:

       ```env
       DB_CONNECTION=sqlite
       DB_DATABASE=./database/database.sqlite
       ```

8. **Migrációk futtatása**

   ```bash
   php artisan migrate
   ```

9. **Frontend assetek buildelése**

   ```bash
   npm run dev
   ```

10. **Fejlesztői szerver indítása**

    ```bash
    php artisan serve
    ```

    Ezután elérhető: `http://127.0.0.1:8000`

---

# ⚡ Gyors parancslista 

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate / php artisan migrate:fresh --seed
npm run dev
php artisan serve
```


