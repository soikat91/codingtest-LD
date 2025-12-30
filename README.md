# Laravel URL Shortener API

A Laravel application providing user authentication and URL shortening services via REST API.

## Features

- User registration and login with Laravel Sanctum
- URL shortening with unique short codes
- Secure password hashing
- JSON API responses with validation
- DataTables integration for web dashboard

## Installation

1. Clone the repository
2. Install dependencies: `composer install`
3. Copy environment file: `cp .env.example .env`
4. Generate app key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Seed database: `php artisan migrate --seed`
7. Start server: `php artisan serve`

## API Documentation

### Authentication

All protected endpoints require Bearer token authentication.

#### Register User
```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "User registered successfully",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2025-12-30T10:00:00.000000Z"
    },
    "token": "1|abc123..."
}
```

**Error Response (422):**
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email has already been taken."]
    }
}
```

#### Login User
```http
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "token": "1|abc123..."
}
```

**Error Response (401):**
```json
{
    "success": false,
    "message": "Invalid credentials"
}
```

### URL Shortener

#### Shorten URL (Authenticated)
```http
POST /api/shorten-url
Authorization: Bearer {token}
Content-Type: application/json

{
    "original_url": "https://example.com/very/long/url"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "URL shortened successfully",
    "shortened_url": "http://127.0.0.1:8000/api/redirect/AbCdEf",
    "short_code": "AbCdEf"
}
```

**Error Response (422):**
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "original_url": ["The original url field is required."]
    }
}
```

#### Redirect to Original URL
```http
GET /api/redirect/{shortCode}
```

**Success:** Redirects to original URL (302)

**Error Response (404):**
```json
{
    "success": false,
    "message": "Short URL not found"
}
```

#### Get User's URLs (Authenticated)
```http
GET /api/urls
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "urls": [
        {
            "id": 1,
            "user_id": 1,
            "original_url": "https://example.com",
            "short_code": "AbCdEf",
            "created_at": "2025-12-30T10:00:00.000000Z",
            "updated_at": "2025-12-30T10:00:00.000000Z"
        }
    ]
}
```

**Error Response (401):**
```json
{
    "success": false,
    "message": "Not Authenticated"
}
```

## Testing

### Seeded Users
- **User:** `test@example.com` / `password`
- **Admin:** `admin@admin.com` / `admin@admin.com`

### Using cURL Examples

#### Register
```bash
curl -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@example.com","password":"password","password_confirmation":"password"}'
```

#### Login
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

#### Shorten URL
```bash
curl -X POST http://127.0.0.1:8000/api/shorten-url \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"original_url":"https://example.com"}'
```

## Technologies Used

- Laravel 11
- Laravel Sanctum for API authentication
- MySQL/PostgreSQL database
- DataTables for web interface
- Bootstrap 5 for styling

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
