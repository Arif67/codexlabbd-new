# Digital Boost — Digital Marketing Agency Website (Laravel)

SeoMaster HTML টেমপ্লেট থেকে বানানো একটি সম্পূর্ণ **dynamic** Laravel 12 ওয়েবসাইট,
সাথে AdminLTE অ্যাডমিন প্যানেল।

## রান করার নিয়ম

```bash
cd app
php artisan serve
```

তারপর ব্রাউজারে যান: http://127.0.0.1:8000

প্রথমবার অন্য মেশিনে সেটআপ করলে:

```bash
composer install
cp .env.example .env        # যদি .env না থাকে
php artisan key:generate
php artisan migrate --seed   # টেবিল + ডিফল্ট ডেটা + অ্যাডমিন ইউজার
php artisan storage:link     # প্রজেক্ট ইমেজ আপলোডের জন্য
```

## পাবলিক পেজসমূহ

| URL         | পেজ        | ডেটা সোর্স                  |
|-------------|------------|-----------------------------|
| `/`         | Home       | DB (services + projects)    |
| `/about`    | About      | static                      |
| `/service`  | Services   | DB (`services` table)       |
| `/project`  | Projects   | DB (`projects` table)       |
| `/contact`  | Contact    | ফর্ম → `contact_messages`   |

## অ্যাডমিন প্যানেল

| URL         | কাজ                                    |
|-------------|-----------------------------------------|
| `/login`    | অ্যাডমিন লগইন                            |
| `/admin`    | ড্যাশবোর্ড (কাউন্ট সহ)                   |
| `/admin/services` | সার্ভিস CRUD (DataTables)          |
| `/admin/projects` | প্রজেক্ট CRUD + ইমেজ আপলোড         |
| `/admin/messages` | কন্টাক্ট মেসেজ দেখা/ডিলিট          |
| `/admin/settings` | সাইট নাম, ফোন, ইমেইল, সোশ্যাল লিংক |

**ডিফল্ট অ্যাডমিন লগইন:**

```
Email:    admin@digitalboost.com
Password: password
```

> প্রোডাকশনে যাওয়ার আগে পাসওয়ার্ড বদলান।

## আর্কিটেকচার

- **Service pattern + Dependency Injection** — প্রতিটি ডোমেইনের জন্য
  `App\Services\Contracts\*Interface` (contract) → `App\Services\*Service`
  (implementation)। বাইন্ডিং: `App\Providers\DomainServiceProvider`।
  কন্ট্রোলারে কনস্ট্রাক্টর ইনজেকশন দিয়ে ব্যবহার করা হয়।
- **AdminLTE** (`jeroennoten/laravel-adminlte`) — অ্যাডমিন লেআউট ও মেনু
  (`config/adminlte.php`)।
- **Yajra DataTables** (`yajra/laravel-datatables`) — অ্যাডমিন লিস্ট পেজে
  সার্ভার-সাইড পেজিনেশন/সার্চ (`*/data` AJAX এন্ডপয়েন্ট)।
- **FormRequest** — ভ্যালিডেশন (`app/Http/Requests/`)।

### Service classes

| Interface                  | Implementation    | দায়িত্ব                  |
|----------------------------|-------------------|---------------------------|
| `ServiceServiceInterface`  | `ServiceService`  | সার্ভিস CRUD + পাবলিক লিস্ট |
| `ProjectServiceInterface`  | `ProjectService`  | প্রজেক্ট CRUD + ইমেজ হ্যান্ডলিং |
| `ContactServiceInterface`  | `ContactService`  | মেসেজ স্টোর/রিড/ডিলিট      |
| `SettingServiceInterface`  | `SettingService`  | সাইট সেটিংস (cache সহ)     |

## ডেটা মডেল

- `services` — icon, title, description, sort_order, is_active
- `projects` — title, category, image, sort_order, is_active
- `site_settings` — key/value (নাম, ফোন, ইমেইল, সোশ্যাল লিংক)
- `contact_messages` — name, email, subject, message, is_read
- `users` — অ্যাডমিন লগইন

## কাস্টমাইজ

- **সাইটের তথ্য** এখন DB-তে → `/admin/settings` থেকে বদলান
  (`config/site.php` শুধু প্রথম সিডের ডিফল্ট মান হিসেবে থাকে)।
- **সার্ভিস / প্রজেক্ট** → অ্যাডমিন প্যানেল থেকে।
- **ডিজাইন/CSS** — `public/css/style.css`
- **লেআউট** — `resources/views/layouts/app.blade.php`, partials `resources/views/partials/`

## কন্টাক্ট ফর্ম থেকে ইমেইল পাঠাতে চাইলে

`.env`-এ SMTP কনফিগ করুন, তারপর `App\Services\ContactService::store()`-এ
`Mail::to(...)->send(...)` যোগ করুন।
# codexlabbd-new
