# Changelog

- Standardized layout and responsive spacing tokens across pages.
- Implemented session-based authentication with secure login/logout and route guards.
- Added database migration and seeders for products and default admin user.

## Auth
- Model: cookie sessions (`SESSION_DRIVER=database`)
- Cookies: HttpOnly, Secure, SameSite=Lax
- TTL: 120 minutes (`SESSION_LIFETIME`)

## Seeding
- Run `php artisan migrate --seed`
- Idempotent via `updateOrCreate`

## New env vars
- `SESSION_SECURE_COOKIE`
- `SESSION_HTTP_ONLY`
- `SESSION_SAME_SITE`

## Routes
| Route | Auth | Redirect |
|-------|------|----------|
| `/` | no | – |
| `/login` | guest | `/` |
| `/registro` | guest | `/` |
| `/produtos` | yes | `/login` |
| `/produto/{id}` | yes | `/login` |
| `/contato` | no | – |
| `/logout` | yes | `/login` |
