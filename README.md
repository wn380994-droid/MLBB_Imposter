# MLBB Imposter Game

A PHP + MySQL (XAMPP) local web game for exactly 5 players.

## Features

- Dashboard with **Start Game** and **History**
- Squad name + exactly 5 unique player names
- Random imposter selection
- Random MLBB topic from 50 starter records:
  - 25 Heroes
  - 15 Items
  - 10 Battle Spells
- Hover/tap flip card
- Imposter sees **IMPOSTER + hint**
- Normal player sees the **exact answer**
- Next player flow
- Last player gets **Play Again** instead of Next
- Play Again keeps the same five names but randomizes the imposter and topic again
- End Game returns to Dashboard
- History stores squad, players, imposter, topic and answer

## XAMPP Setup

1. Start **Apache** and **MySQL** in XAMPP.
2. Copy this folder into:
   `C:/xampp/htdocs/MLBB_Imposter_Game/`
3. Open phpMyAdmin.
4. Import:
   `database/schema.sql`
5. Check `config.php`:
   - DB_HOST = `***.*.*.*`
   - DB_NAME = `mlbb_imposter`
   - DB_USER = `root`
   - DB_PASS = empty by default on XAMPP
6. Open:
   `http://localhost/MLBB_Imposter_Game/`

## Important

The project uses PHP sessions for the current game state and MySQL for game history and the topic database.

For a production deployment, add authentication, CSRF protection, HTTPS, rate limiting and stricter server-side validation.

## Current data note

The starter dataset is designed for the game mechanic, so hints are deliberately indirect rather than exact definitions. MLBB changes over time; update the seed data when hero/item/spell names or mechanics change.
