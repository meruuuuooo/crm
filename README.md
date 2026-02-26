# CRM Kent — Laravel CRM System

A full-featured Customer Relationship Management (CRM) system built with **Laravel 12**, **Livewire 4**, **Flux UI**, and **Tailwind CSS 4**.

---

## 📋 Requirements

Before cloning and running this project, make sure your machine has the following installed:

| Requirement | Version |
| --- | --- |
| PHP | `^8.2` |
| Composer | `^2.x` |
| Node.js | `^18.x` or later |
| npm | `^9.x` or later |
| Git | Latest |
| SQLite | Bundled with PHP (default) |

> **Optional:** MySQL / PostgreSQL if you prefer a different database driver.

---

## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/crm_kent.git
cd crm_kent/my-app
```

> Replace `your-username` with the actual GitHub username or organization.

---

### 2. Install PHP Dependencies

```bash
composer install
```

---

### 3. Set Up Environment File

```bash
cp .env.example .env
```

Then generate the application key:

```bash
php artisan key:generate
```

---

### 4. Configure the Database

By default, the project uses **SQLite**. The database file is located at `database/database.sqlite`.

If the file does not exist, create it:

```bash
touch database/database.sqlite
```

> **Using MySQL or PostgreSQL instead?**
> Open `.env` and update the following variables:
>
> ```env
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=crm_kent
> DB_USERNAME=root
> DB_PASSWORD=your_password
> ```

---

### 5. Run Database Migrations

```bash
php artisan migrate
```

To also seed the database with sample data (if seeders exist):

```bash
php artisan migrate --seed
```

---

### 6. Install Node.js Dependencies

```bash
npm install
```

---

### 7. Build Frontend Assets

For **production**:

```bash
npm run build
```

For **development** (with hot-reload):

```bash
npm run dev
```

---

### 8. Start the Development Server

```bash
php artisan serve
```

The application will be available at: **<http://127.0.0.1:8000>**

---

## ⚡ Quick Setup (One Command)

Alternatively, run all setup steps at once using the Composer setup script:

```bash
composer run setup
```

This will automatically:

1. Install PHP dependencies
2. Copy `.env.example` to `.env`
3. Generate the application key
4. Run migrations
5. Install Node.js dependencies
6. Build frontend assets

---

## 🖥️ Running the Full Dev Environment

To start the web server, queue worker, and Vite dev server all at once:

```bash
composer run dev
```

---

## 📦 CRM Modules

This system includes the following CRM modules:

- 🏢 **Companies** — Manage business accounts
- 👤 **Contacts** — Track people and relationships
- 💼 **Deals** — Monitor sales opportunities
- 🎯 **Leads** — Capture and qualify prospects
- 📣 **Campaigns** — Run marketing campaigns
- 🗂️ **Projects** — Oversee project progress
- 📝 **Tasks** — Assign and track tasks
- 📄 **Contracts** — Manage contracts
- 📊 **Estimations** — Create cost estimations
- 📋 **Proposals** — Draft and send proposals
- 🧾 **Invoices** — Handle billing and payments
- 🔄 **Pipelines** — Visualize sales pipelines
- 📅 **Activities** — Log customer interactions

---

## 🧪 Running Tests

```bash
php artisan test
```

Or using Pest directly:

```bash
./vendor/bin/pest
```

---

## 🧹 Code Linting

```bash
composer run lint
```

---

## 🛠️ Tech Stack

| Layer | Technology |
| --- | --- |
| Backend | Laravel 12 |
| Authentication | Laravel Fortify |
| Frontend Components | Livewire 4 + Flux UI |
| Styling | Tailwind CSS 4 |
| Build Tool | Vite 7 |
| Default Database | SQLite |
| Testing | PestPHP |

---

## 🔐 Default Login

After running migrations and seeders, you may log in with:

> Check `database/seeders/` for default credentials, or register a new account at `/register`.

---

## 📁 Project Structure

```text
my-app/
├── app/
│   ├── Http/Controllers/     # HTTP Controllers
│   ├── Livewire/             # Livewire components
│   ├── Models/Crm/           # CRM Eloquent models
│   └── Helpers/              # Helper classes
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── resources/
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   └── views/                # Blade templates
├── routes/
│   ├── web.php               # Web routes
│   └── settings.php          # Settings routes
└── tests/                    # Automated tests
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
