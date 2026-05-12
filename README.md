# 🍽️ Eetfestijn — Inschrijvingen voor het Belgisch verenigingsleven

> Een Laravel-applicatie om eetfestijnen te organiseren: van Chiro-spaghettiavond tot fanfare-mosselsouper. Eén plek voor reservaties, gerechtenkeuze, betalingsoverzicht en kookplanning.

---

## 🧠 Concept

### Welk probleem lost het op?

Elke vereniging in Vlaanderen organiseert minstens één eetfestijn per jaar als fundraiser. Een Chiro, een fanfare, een voetbalclub, een oudercomité — allemaal hetzelfde patroon: één penningmeester, een spreadsheet die door 10 mensen langs elkaar wordt bewerkt, WhatsApp-berichten met "noteer er nog 4 stoofvlees bij voor de buurvrouw", en de avond zelf nog snel turven aan de inkom.

**Eetfestijn** vervangt die chaos door één gedeelde plek waar bezoekers zich inschrijven met hun gerechtkeuze, en de organiser in één oogopslag ziet:

- 📋 Wie heeft ingeschreven en met hoeveel personen
- 🍲 Hoeveel porties van elk gerecht moeten klaargemaakt worden
- 💳 Wie heeft al betaald en wie niet

### Waarom is dit relevant in België?

Vlaanderen heeft een uitzonderlijk rijk verenigingsleven. Volgens het Vlaams Steunpunt Vrijwilligerswerk telt Vlaanderen meer dan **één vereniging per 50 inwoners**, en het overgrote deel financiert zich (mede) met eetfestijnen. Het is een diepgewortelde traditie: vol-au-vent in de parochiezaal, stoofvlees met frieten in de sporthal, kinderspaghetti voor de jeugdbeweging.

Tegelijk gebeurt de administratie nog altijd met papier, Excel-bestanden via mail, en losse WhatsApp-berichten. Dit zorgt voor:

- **Dubbele reservaties** of vergeten inschrijvingen
- **Verkeerde porties** voor de kok (zelfs voor en na het festijn nog uren werk)
- **Onduidelijk wie al betaald heeft** — pas weken later wordt de balans opgemaakt
- **Geen historiek** om volgend jaar slimmer in te kopen

### Wie zijn de gebruikers?

| Rol | Wat ze doen |
|---|---|
| **Penningmeester / coördinator** | Maakt het event aan, voegt gerechten met prijs toe, bekijkt dashboard, markeert betalingen |
| **Bezoeker / inschrijver** | Bezoekt de eventpagina, vult formulier in, kiest gerechten met aantallen |
| **Kok / cateraar** | Krijgt via het dashboard exacte totalen per gerecht, weet wat bestellen |

---

## ⚙️ Installatie

### Vereisten

- PHP 8.2+
- Composer
- Node.js 18+ & npm
- MySQL 8+ (of MariaDB 10.6+)

### Stap 1: Clone de repository

```bash
git clone https://github.com/guiume123/eetfestijn.git
cd eetfestijn
```

### Stap 2: Installeer dependencies

```bash
composer install
npm install
```

### Stap 3: Configureer de environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` en pas aan:

```env
APP_NAME=Eetfestijn
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eetfestijn
DB_USERNAME=root
DB_PASSWORD=
```

| Variabele | Beschrijving |
|---|---|
| `APP_NAME` | Naam getoond in de browser-tab |
| `APP_TIMEZONE` | UTC voor opslag; UI converteert naar lokale tijd via Carbon |
| `DB_DATABASE` | MySQL-database naam (moet manueel aangemaakt worden) |
| `DB_USERNAME` / `DB_PASSWORD` | MySQL-credentials |

### Stap 4: Maak de database aan

```bash
mysql -u root -p -e "CREATE DATABASE eetfestijn CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Stap 5: Run migrations + seed

```bash
php artisan migrate --seed
```

Dit creëert alle tabellen en vult ze met realistische data:

| Tabel | Records |
|---|---|
| `events` | 4 Belgische eetfestijnen |
| `dishes` | 5-7 gerechten per event |
| `reservations` | 10-15 inschrijvingen per event |
| `dish_reservation` (pivot) | Gerechtkeuzes met quantity per reservatie |

### Stap 6: Build frontend assets + start server

```bash
composer run dev
```

Dit start tegelijk de PHP-server, Vite (hot reload), en queue worker. Bezoek `http://localhost:8000`.

---

## 🧪 Gebruik

### Hoofdfunctionaliteit

**Events-overzicht (`/events`)**
- Filter komende / voorbije / alle events
- Toont per event: locatie, datum, aantal reservaties, status
- Paginering (10 events per pagina)

**Event detail (`/events/{event}`)**
- Volledige beschrijving + datum + locatie
- Menu met prijzen
- Knoppen naar inschrijven, dashboard, bewerken, verwijderen

**Inschrijven (`/events/{event}/reserveren`)**
- Naam, email, telefoon, aantal personen, opmerkingen
- Multi-select gerechten met quantity per gerecht
- Validatie: minstens 1 gerecht, max 20 personen, inschrijving alleen vóór deadline

**Dashboard (`/events/{event}/reservations`)**
- **Totalen per gerecht** voor de kok (bv. "67× stoofvlees, 23× vol-au-vent")
- Tabel met alle reservaties + sortering op naam/datum/aantal
- Eén klik om betaling te markeren (toggle)
- Totaalprijs per reservatie automatisch berekend via accessor

### Voorbeeldscenario's

**Scenario 1 — Chiro-leider plant spaghettiavond**

Marie van Chiro Sint-Jan logt in, klikt "+ Nieuw event", vult titel "Spaghettiavond Chiro Sint-Jan", locatie "Parochiezaal Genk", event-datum, deadline. Voegt nadien 4 gerechten toe via Tinker of seeder. Deelt link `/events/spaghetti-avond-xyz` op Facebook.

**Scenario 2 — Bezoeker schrijft in**

Jan bezoekt de link, ziet de menukaart, vult formulier in: "Jan Peeters, +32 478 12 34 56, 4 personen, 2× spaghetti bolognese + 2× kinderspaghetti + 4× dame blanche". Klikt bevestigen. Krijgt bevestigingsmelding.

**Scenario 3 — De avond zelf**

Marie opent het dashboard om 17:00 voor het festijn. Ziet meteen: **78× spaghetti, 22× kinderspaghetti, 65× dame blanche**. Belt de kok met exacte aantallen. Markeert bij aankomst van elke familie de betaling als binnen.

**Scenario 4 — Inschrijvingen gesloten**

3 dagen voor het event sluit de inschrijfdeadline automatisch (via Carbon-accessor `registration_open`). De inschrijfknop verdwijnt automatisch op de eventpagina.

---

## 🔥 Momentum Factor

### Wat maakt deze app krachtig?

**1. Eén waarheidsbron in plaats van Excel-versies.**
Iedereen — coördinator, kok, kassa — kijkt naar dezelfde dataset. Geen "ik had nog een mailtje gestuurd"-discussies.

**2. Automatische totalen voor de kok.**
De pivot-tabel `dish_reservation` met `quantity` maakt aggregatie triviaal. Een simpele query toont meteen hoeveel porties van elk gerecht. Geen handmatig turven meer.

**3. Carbon-gestuurde deadlines.**
De `registration_open` accessor op het `Event` model checkt automatisch of de deadline voorbij is. De UI past zich aan zonder dat de organiser iets moet uitvinkten.

**4. Laravel 13 conventies overal.**
- Eloquent relaties (`hasMany`, `belongsToMany` met `withPivot`)
- RESTful resource controllers
- Pivot-tabel correct genoemd: `dish_reservation` (alfabetisch, singular)
- Accessors via `Attribute::make()` (Laravel 13 syntax)
- Migrations met foreign keys en cascade delete
- Factories + seeder met realistische Belgische data
- Form validation in elke store/update method
- Sorting via URI met whitelist + `withQueryString()` op pagination
- `compact()` voor view data

**5. EUR in cents opgeslagen.**
`price_cents` als integer voorkomt floating-point rounding errors. Een accessor `price_euro` formatteert pas op presentatieniveau.

### Hoe kan dit groeien tot een echt product?

| Feature | Wat het ontgrendelt |
|---|---|
| **Email-bevestigingen** | Bezoekers krijgen automatisch een mail met QR-code voor aan de inkom |
| **Online betalen (Mollie/Bancontact)** | Penningmeester hoeft niet meer manueel betalingen aan te vinken |
| **Multi-vereniging accounts** | Eén platform voor alle Belgische verenigingen — login + tenant scoping |
| **Voorraadbeheer** | Per gerecht een max-quantity zetten, automatisch "uitverkocht" wanneer bereikt |
| **CSV-export** | Penningmeester downloadt fiscaal rapport voor de boekhouding |
| **Recurring events** | "Elke laatste zaterdag van de maand spaghetti" — patronen voor stamcafés |
| **Allergie-rapportage** | De `notes` veld automatisch gegroepeerd zodat de kok allergieën vooraf ziet |

Het datamodel zit fundamenteel goed — events, dishes, reservations, pivot. Daarmee kan dit doorgroeien van een "Chiro-tooltje" tot een vol platform voor het volledige Vlaamse verenigingsleven (~16.000 verenigingen).

---

## 🛠️ Tech Stack

| Laag | Technologie |
|---|---|
| Backend | Laravel 13 (PHP 8.2+) |
| Frontend | Blade templates + Tailwind CSS v4 |
| Database | MySQL 8 |
| Date handling | Carbon (UTC opslag, lokaal display) |
| Asset bundling | Vite |
| Templating | Blade met layout inheritance (@yield / @section) |

---

## 📐 Datamodel

```
events (1) ────────< (many) dishes
   │
   └────< (many) reservations
                       │
                       └──< (many) dish_reservation (pivot, met quantity)
                                          │
                                          └──> dishes
```

- **`events`**: title, location, description, event_date, registration_deadline, slug
- **`dishes`**: event_id, name, type (enum), price_cents, max_quantity
- **`reservations`**: event_id, name, email, phone, number_of_people, notes, paid_at
- **`dish_reservation`** (pivot): dish_id, reservation_id, **quantity**

---

## 👥 Auteur

Guillaume Huysmans · Laravel-examen 2026
