# 🏥 MyBooking HPD — Room Booking System

> **Hospital Port Dickson** · Room & Facility Booking Management System

[![Laravel](https://img.shields.io/badge/Laravel-13-red?style=flat-square&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.x-blue?style=flat-square&logo=tailwindcss)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-purple?style=flat-square&logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square&logo=mysql)](https://mysql.com)

---

## 📌 About

**MyBooking HPD** is a web-based room booking system built for **Hospital Port Dickson**. It streamlines the process of reserving rooms, meeting halls, and training facilities within the hospital complex.

The system replaces manual booking processes with a centralized digital platform, providing real-time availability, admin approvals, and automated notifications.

---

## 🎯 Key Features

### 👤 For Users
- 🔍 Browse available rooms with search & filter
- 📅 Book rooms with real-time schedule view
- 📊 Track booking status (pending / approved / rejected)
- 🔔 Receive in-app notifications
- 👤 Manage personal profile

### 🛡️ For Admin (PIC Bilik)
- ✅ Approve / reject booking requests
- 🏢 Manage assigned rooms only
- 📅 View room schedules in calendar
- 📊 Monitor booking statistics

### ⚡ For Super Admin
- 👥 Manage all users (create, edit, assign roles)
- 🏢 Manage all rooms (add, edit, delete)
- ✅ Full booking approval access
- 📅 System-wide calendar view
- 🔐 Assign rooms to Admin PIC

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | Laravel 13 |
| **Frontend** | Tailwind CSS v4, Vanilla JavaScript, Alpine.js |
| **Database** | MySQL 8.0 |
| **Build Tool** | Vite 8 |
| **Fonts** | Plus Jakarta Sans, Inter |
| **Real-time** | Laravel Echo + Pusher |

---

## ⚙️ Installation

### Prerequisites
- PHP 8.3+
- Composer
- Node.js 18+
- MySQL

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/your-repo/mybooking-hpd.git
cd mybooking-hpd

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure database in .env
# DB_DATABASE=mybooking_db
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Run migrations & seeders
php artisan migrate --seed

# 8. Build frontend assets
npm run build

# 9. Start the server
php artisan serve
For development with hot reload:

bash
npm run dev
👥 Demo Credentials
Role	Email	Password
⚡ Super Admin	superadmin@moh.gov.my	password
🛡️ Admin PIC	admin.tanjungtuan@moh.gov.my	password
👤 User	johndoe@moh.gov.my	password
⚠️ Demo accounts are for testing purposes only. Change passwords in production.

📊 Software Quality Testing Report
📌 System Description
MyBooking HPD was tested to evaluate the system's quality based on:

⚡ Performance

🔒 Reliability

🎨 Usability

🛡️ Security

📊 Data Consistency

The testing approach focuses on real-world usage scenarios, edge cases, system logic validation, and role-based access control.

Note: Testing was conducted on a free hosting environment, so it does not cover large-scale stress testing.

🧪 Test Results
No	Quality Aspect	Test Scenario	Expected Result	Status
1	Performance	Load room listing page	< 2 seconds	⚠️ Needs optimization
2	Performance	User dashboard with lots of data	Responsive	✅ Good
3	Performance	Admin dashboard (many bookings)	< 2 seconds	⚠️ Needs query optimization
4	Performance	Upload many images	No timeout	⚠️ Depends on hosting
5	Performance	Alternative room recommendations	Fast & efficient	⚠️ Needs optimization
6	Reliability	Booking for today's date	Valid	⚠️ Timezone risk
7	Reliability	Booking time validation	Cannot be the same	✅ Valid
8	Reliability	Cancel approved booking	Rejected	✅ Valid
9	Reliability	Cancel another user's booking	Rejected (403)	✅ Secure
10	Reliability	Deactivate an active room	Consistent	⚠️ Needs notification
11	Usability	Login with wrong password	Clear error	✅ Good
12	Usability	Booking from room details	Auto select	⚠️ UX can be confusing
13	Usability	Approve booking	Successful & clear	✅ Good
14	Usability	Reject without reason	Must be rejected	⚠️ Server validation needed
15	Usability	Redirect based on role	Correct	✅ Good
16	Security	Admin access by regular user	Rejected	✅ Secure
17	Security	Access without login	Redirect to login	✅ Secure
18	Security	SQL Injection	Unsuccessful	✅ Secure
19	Security	XSS	Not executed	✅ Secure
20	Security	CSRF attack	Rejected	✅ Secure
21	Security	Mass assignment	Secure	✅ Secure
22	Security	Upload dangerous file	Rejected	✅ Secure
23	Data Consistency	Double booking (pending)	Still allowed	✅ By design
24	Data Consistency	Double approval (race condition)	Must be prevented	❌ Needs fixing
25	Data Consistency	Delete room with history	Data remains safe	⚠️ Needs soft delete
🔴 Key Findings
1. Potential Race Condition in Booking Approval
If two admins approve conflicting bookings simultaneously, the system could potentially approve both.

Impact:

Double booking at the same time

Data inconsistency

Recommended Fix:

php
DB::transaction(function () use ($booking) {
    $locked = Booking::where('id', $booking->id)->lockForUpdate()->first();
    // Re-check conflict, then update status
});
2. Reject Reason Validation Is Inconsistent
Validation is only done on the frontend (HTML), not on the backend.

Impact:

Bookings can be rejected without a reason

Recommended Fix:

php
$validated = $request->validate([
    'status' => ['required', 'in:approved,rejected'],
    'notes'  => ['required_if:status,rejected', 'nullable', 'string', 'max:500'],
]);
3. Query Optimization (N+1 Problem)
Features such as room listing and alternative recommendations still perform repeated queries.

Impact:

Performance degrades when there is a lot of data

Recommended Fix:

php
// Use eager loading
$bookings = Booking::with(['user', 'room'])->paginate(10);
🛠️ Improvement Recommendations
No	Recommendation	Priority
1	Fix race condition using database transactions & locking	🔴 High
2	Add backend validation for reject reason	🔴 High
3	Optimize queries with eager loading	🟡 Medium
4	Configure timezone (APP_TIMEZONE=Asia/Kuala_Lumpur)	🟡 Medium
5	Use soft delete for rooms	🟢 Low
📊 System Quality Summary
Aspect	Status
⚡ Performance	⚠️ Needs optimization
🔒 Reliability	✅ Good
🎨 Usability	✅ Good
🛡️ Security	✅ Secure
📊 Data Consistency	⚠️ Needs improvement
📈 Conclusion
Overall, MyBooking HPD:

✅ Functions well from a functional perspective

✅ Is secure from a basic security standpoint

✅ Has a solid system structure

However, there are still several areas that need improvement:

⚡ Performance optimization

🔄 Concurrency handling

🛡️ Backend validation

With these improvements, the system will become more stable, scalable, and ready for real-world deployment.

📁 Project Structure
text
mybooking-hpd/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── BookingController.php
│   │   │   │   ├── RoomController.php
│   │   │   │   └── UserController.php
│   │   │   ├── Auth/
│   │   │   ├── AuthController.php
│   │   │   ├── BookingController.php
│   │   │   ├── CalendarController.php
│   │   │   ├── NotificationController.php
│   │   │   ├── ProfileController.php
│   │   │   └── RoomController.php
│   │   └── Middleware/
│   │       ├── IsAdmin.php
│   │       └── IsSuper.php
│   ├── Models/
│   │   ├── Booking.php
│   │   ├── Room.php
│   │   └── User.php
│   └── Notifications/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── bookings/
│       ├── calendar/
│       ├── components/
│       ├── layouts/
│       ├── notifications/
│       ├── profile/
│       └── rooms/
├── routes/
│   └── web.php
└── public/
🎨 Design System
Element	Value
Primary Color	Purple #7c3aed
Secondary	Indigo #6366f1
Accent	Pink #ec4899, Cyan #06b6d4
Background	#fafbff (soft white)
Text Primary	#0f1419
Border	#eef1f8
Radius	0.875rem – 1.5rem
Font	Plus Jakarta Sans
📅 Related Projects
This testing was conducted as part of Daily Project 6, based on competitor analysis that identified the main quality aspects:

⚡ Performance

🔒 Reliability

🎨 Usability

🛡️ Security

📊 Data Consistency

📄 License
This project is developed for Hospital Port Dickson internal use.