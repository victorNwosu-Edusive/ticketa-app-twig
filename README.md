# Ticketa Web App

Ticket management web application powered by PHP, Twig, and Tailwind (via CDN). It stores users and tickets in flat JSON files for a lightweight setup.

## Prerequisites

1. **PHP** 8.1 or newer with the built-in web server extension
2. **Composer** for dependency installation

## Installation

1. Clone the repository and enter the project directory.
2. Install dependencies:
   ```bash
   composer install
   ```

## Local Development

1. Start the PHP development server from the `public` directory root:
   ```bash
   php -S localhost:8000 -t public
   ```
2. Visit [http://localhost:8000](http://localhost:8000) to access the landing page.

## Authentication

- Dashboard, ticket listing, creation, and editing require an authenticated session.
- Default credentials (from `data/users.json`):
  - Email: `ooo@gmail.com`
  - Password: `123456`
- Additional accounts can be created via the signup form.

## Data Storage

- `data/users.json`: Registered users
- `data/tickets.json`: Ticket records

Changes made through the UI are persisted immediately to these files.

## Project Structure

- `public/`: Entry-point PHP scripts
- `templates/`: Twig templates (layouts, pages, partials)
- `data/`: JSON storage for users and tickets
- `vendor/`: Composer-managed dependencies

## Common Tasks

1. **Create a ticket**: Log in → `Create Ticket`
2. **View tickets**: Log in → `Tickets`
3. **Edit/Delete ticket**: Available from the ticket list
4. **Log out**: Use the `Logout` link in the navigation bar

## Deployment Notes

- Serve the `public/` directory through your web server.
- Ensure the web server process has read/write access to the `data/` directory.
- For production, replace the flat-file storage with a secure database and hash user passwords.
