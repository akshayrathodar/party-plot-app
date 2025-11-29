# Laravel Project Structure

This document shows the file structure we'll create for the Party Plot Listing Platform.

```
party-plot-platform/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── PageController.php
│   └── ...
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── components/
│   │   │   ├── header.blade.php
│   │   │   └── footer.blade.php
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── about.blade.php
│   │   │   └── contact.blade.php
│   └── ...
├── public/
│   └── assets/  (copy from theme)
│       ├── css/
│       ├── js/
│       ├── img/
│       └── fonts/
├── routes/
│   └── web.php
└── ...
```



