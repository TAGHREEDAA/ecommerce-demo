# E-commerce Order Flow Demo

A Laravel web app for a simple e-commerce flow: browse products, add to cart, place an order, and let an admin refund it.

## Tech Stack

- PHP 8.2 / Laravel 12
- Breeze (authentication)
- Tailwind CSS
- MySQL / SQLite

## Installation & Setup

```bash
git clone <repo-url>
cd ecommerce-demo
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

The app will be available at `http://localhost:8000`

For development with live reloading, replace `npm run build` with `npm run dev` and keep it running alongside `php artisan serve`.

## Seeded Accounts

All accounts use the password: `password`

| Role  | Email               |
|-------|---------------------|
| Admin | admin@ecommerce.com |
| User  | user1@ecommerce.com |
| User  | user2@ecommerce.com |

## Pages

### Customer (requires login)

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/products` | Browse products with stock status |
| GET | `/cart` | View cart and total |
| POST | `/cart/items/{product}` | Add product to cart |
| POST | `/orders` | Place order (cash on delivery) |
| GET | `/orders` | Order history |
| GET | `/orders/{order}` | Order detail |

### Admin (requires admin account)

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/admin/orders` | List all orders |
| GET | `/admin/orders/{order}` | Order detail |
| POST | `/admin/orders/{order}/refund` | Refund an order |

## Architecture Overview

Every request goes through the same layers:

```
HTTP Request
     │
     ├── Gate ──────────── checks is_admin for admin routes
     │
FormRequest ───────────── validates fields (rules)
     │                    validates business rules (after)
     │
Controller ────────────── delegates only, no logic
     │
Service ───────────────── all business logic
     │    CartService:  add to cart, get cart items
     │    OrderService: place order, refund, list orders
     │
Model ─────────────────── relationships + computed attributes
     │    Cart/CartItem:    total_price computed (not stored)
     │    Order/OrderItem:  total_price stored (price snapshot)
     │
  Database
```

## Architecture Decisions

### Service classes for business logic

Controllers only call a service method and return a response. All the actual logic (creating an order, validating stock, processing a refund) lives in `CartService` and `OrderService`. This keeps controllers easy to read and makes the logic easy to find.

### FormRequests for all validation

Every action that needs validation has its own FormRequest class. For simple field rules I use `rules()`. For checks that need the database (like "is this order already refunded?") I use the `after()` callback — it runs after field validation passes, so I can add errors without throwing exceptions.

### Computed vs stored `total_price`

Cart and cart item totals are computed on the fly (`quantity × price`) and never stored in the database. There's no point saving a number that can always be recalculated from the source.

Order and order item totals are stored. Once an order is placed, the prices shouldn't change even if the product price changes later.

### Stock validation is cumulative

When adding to cart, the validation checks `existing cart quantity + new quantity ≤ stock`. A simple `max` rule would let someone add 5 items twice and end up with 10, bypassing the stock limit. The `SufficientStockRule` prevents that.

### Authentication via Laravel Breeze

I used Breeze to handle all authentication out of the box — registration, login, logout, email verification, and the profile page. It generates the routes, controllers, views, and middleware needed for a full auth flow, so I didn't have to write any of that manually.

The only addition I made on top of Breeze is the `is_admin` flag on the users table. I didn't build a separate admin auth system — the same login page is used for everyone, and the admin check happens after login.

### Admin access via Laravel Gate

I defined a single `admin` gate in `AppServiceProvider` that checks `$user->is_admin`. The admin routes use `can:admin` middleware and the refund request checks it in `authorize()`. This keeps authorization in one place instead of spreading it across controllers.

## Business Rules

- Only logged-in users can add to cart or place orders
- Adding to cart respects cumulative stock (cart quantity + request quantity must not exceed stock)
- Unit price is captured at order time — changing the product price later doesn't affect existing orders
- Refunding an order restores the stock for all items
- An order can only be refunded once

## Assumptions

- Payment method is cash on delivery — no payment gateway integration
- Cart items can't be edited or removed after being added
- Prices are stored as whole numbers (no cents)
- No concurrency locking — stock could go negative under very high simultaneous traffic
- This is a demo task, so no emails, no pagination, no soft deletes
