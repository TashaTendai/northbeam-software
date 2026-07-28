# Northbeam Software

A full-stack business website built for a small software/IT consultancy, featuring a public-facing site, a custom admin panel, and full CRUD functionality for managing services — built from scratch as a hands-on PHP/MySQL learning project.

## Features

**Public site**
- Responsive multi-page site (Home, About, Services, Contact) built with custom CSS (no frameworks)
- Services page pulls live data from the database, with contextual icons and illustrations
- Contact form with server-side validation and database storage
- Custom 404 error page

**Admin panel**
- Services without a manually uploaded image automatically display a placeholder graphic
- Secure login using hashed passwords (`password_hash` / `password_verify`) and PHP sessions
- Dashboard for viewing and managing contact form submissions (with read/unread status)
- Full CRUD for services: create, edit, delete, and image upload
- Session-protected routes with cache-control headers to prevent stale page access after logout

## Tech stack

- **Backend:** PHP (procedural, `mysqli` extension)
- **Database:** MySQL
- **Frontend:** HTML, custom CSS (design tokens, no framework), vanilla JavaScript
- **Local environment:** XAMPP (Apache + MySQL)

## Setup instructions

1. Install [XAMPP](https://www.apachefriends.org/) and start **Apache** and **MySQL**.
2. Clone or copy this project into your XAMPP `htdocs` folder:
   ```
   C:\xampp\htdocs\northbeam-software\
   ```
3. Open **phpMyAdmin** (`http://localhost/phpmyadmin`) and create a new database named `northbeam_db`.
44. Import the database schema by going to **Import** in phpMyAdmin (with `northbeam_db` selected) and choosing `database/northbeam_db.sql` from this project. This creates the three tables: `users`, `services`, and `contact_messages`.
5. Create an admin user manually in the `users` table, using `password_hash()` to generate a hashed password (see `includes/db.php` for connection details — default XAMPP credentials are `root` with no password).
6. Visit `http://localhost/northbeam-software/` to view the public site, or `http://localhost/northbeam-software/admin/login.php` to access the admin panel.

## Database schema

**`users`** — admin accounts
- `id`, `username`, `password` (hashed), `created_at`

**`services`** — services shown on the public Services page
- `id`, `title`, `description`, `image` (file path, defaults to a placeholder), `created_at`

**`contact_messages`** — submissions from the public contact form
- `id`, `name`, `email`, `subject`, `message`, `submitted_at`, `is_read`

## Known limitations

- The contact form does not yet have CSRF protection.
- After logging out, the browser's back button may briefly show a cached view of the admin dashboard due to browser back-forward caching (bfcache) — refreshing correctly redirects to the login page, and the underlying session protection is unaffected.
- Service icons are assigned via basic keyword-matching on the title, which may not scale well to services with titles outside the current keyword set (falls back to a generic icon).

## Author

Natasha Tendai Mangachena
