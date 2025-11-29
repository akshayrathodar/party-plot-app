# Laravel Setup Instructions

## File Structure

All Laravel Blade files have been created in the `laravel-views/` directory. Here's how to set them up in your Laravel project:

### 1. Copy Files to Laravel Project

```bash
# Copy layout file
cp laravel-views/layouts-app.blade.php your-laravel-project/resources/views/layouts/app.blade.php

# Copy components
cp laravel-views/components-header.blade.php your-laravel-project/resources/views/components/header.blade.php
cp laravel-views/components-footer.blade.php your-laravel-project/resources/views/components/footer.blade.php

# Copy pages
cp laravel-views/pages-home.blade.php your-laravel-project/resources/views/pages/home.blade.php
cp laravel-views/pages-about.blade.php your-laravel-project/resources/views/pages/about.blade.php
cp laravel-views/pages-contact.blade.php your-laravel-project/resources/views/pages/contact.blade.php

# Copy controllers
cp laravel-controllers-PageController.php your-laravel-project/app/Http/Controllers/PageController.php
cp laravel-controllers-ContactController.php your-laravel-project/app/Http/Controllers/ContactController.php

# Copy routes (merge with existing web.php)
# Add routes from laravel-routes-web.php to your routes/web.php
```

### 2. Copy Assets

Copy the entire `assets/` folder from the theme to your Laravel `public/` directory:

```bash
cp -r assets/ your-laravel-project/public/assets/
```

### 3. Install Laravel Project (if not already done)

```bash
composer create-project laravel/laravel party-plot-platform
cd party-plot-platform
```

### 4. Update Routes

Add the routes from `laravel-routes-web.php` to your `routes/web.php` file.

### 5. Create Controllers

The controller files are provided. Make sure they're in the correct namespace.

### 6. Environment Setup

Update your `.env` file:

```env
APP_NAME="Party Plot Platform"
APP_URL=http://localhost:8000

# Mail configuration (for contact form)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@partyplot.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 7. Run Migrations (when database is ready)

```bash
php artisan migrate
```

### 8. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` to see your application.

## Next Steps

1. **Create Database Models:**
   - PartyPlot
   - Category
   - Tag
   - Lead
   - Contact

2. **Implement Authentication:**
   - Use Laravel Breeze or Jetstream
   - Create vendor and admin roles

3. **Create Migrations:**
   - parties table
   - categories table
   - tags table
   - party_plot_tag pivot table
   - leads table
   - contacts table

4. **Implement Features:**
   - Party plot CRUD
   - Image uploads
   - Lead generation
   - Search functionality
   - SEO tag pages

## Notes

- All asset paths use `asset()` helper for proper Laravel asset management
- Routes use named routes for better maintainability
- Controllers include TODO comments for database integration
- Forms include CSRF protection
- Error handling is included in forms

## Troubleshooting

If assets don't load:
1. Check that assets are in `public/assets/`
2. Run `php artisan storage:link` if using storage
3. Clear cache: `php artisan cache:clear`

If routes don't work:
1. Check route names match in views
2. Run `php artisan route:list` to see all routes
3. Clear route cache: `php artisan route:clear`



