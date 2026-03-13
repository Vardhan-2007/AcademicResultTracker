# AcademicResultTracker
Project for my academics subject Data Base Management System
# 🎓 Smart Student Result Management System (SSRMS)

A **web-based Student Result Management System** built using **PHP, MySQL, Bootstrap, and Chart.js**.  
The system provides **role-based access** for **Students, Faculty, and Admin** to manage and analyze academic performance.

This project was developed as part of a **Database Management Systems (DBMS) project** using **XAMPP**.

---

# 🚀 Features

## 👨‍🎓 Student Portal
- Secure student login
- View subject-wise results
- Performance summary
- Pass / Backlog statistics
- Average marks calculation
- CGPA estimation
- Performance chart visualization

---

## 👨‍🏫 Faculty Portal
- Secure faculty login
- Add or update student marks
- View all students' marks for assigned subject
- Subject performance analytics
- Pass percentage calculation
- Highest & lowest marks
- Top 3 students leaderboard
- Visual charts for result analysis

---

## 👑 Admin Portal
- Manage complete academic system
- View all students
- View faculty members
- View subjects and results
- Dashboard statistics

### Admin Analytics
- Total students
- Total faculty
- Total subjects
- Total backlogs
- Pass vs Fail analytics
- Subject-wise performance chart
- Department distribution chart

---

## 📊 KPI Dashboard
Before entering the system, a **KPI Dashboard** shows:

- Total students
- Total branches
- Total backlogs
- Available departments

---

# 🖥️ System Screens

Main components of the system:

- Home Portal
- KPI Dashboard
- Student Dashboard
- Faculty Dashboard
- Admin Dashboard

---

# 🛠️ Technologies Used

| Technology | Purpose |
|------------|---------|
| PHP | Backend server logic |
| MySQL | Database management |
| HTML5 | Web page structure |
| CSS3 | Styling |
| Bootstrap 5 | UI framework |
| JavaScript | Interactivity |
| Chart.js | Data visualization |
| XAMPP | Local server environment |

---

# 📁 Project Structure

```
SSRMS
│
├── index.php
├── kpi_dashboard.php
├── db.php
├── style.css
│
├── student_login.php
├── faculty_login.php
├── admin_login.php
│
├── student_dashboard.php
├── faculty_dashboard.php
├── admin_dashboard.php
│
├── add_marks.php
├── logout.php
│
└── database.sql
```

---

# 🗄️ Database Structure

Database name:

```
ssms
```

### Tables Used

#### 1️⃣ students

| Column | Type |
|------|------|
| student_id | INT (PK) |
| name | VARCHAR |
| roll_no | VARCHAR |
| email | VARCHAR |
| password | VARCHAR |
| department | VARCHAR |

---

#### 2️⃣ faculty

| Column | Type |
|------|------|
| faculty_id | INT (PK) |
| name | VARCHAR |
| email | VARCHAR |
| password | VARCHAR |
| subject_id | INT |

---

#### 3️⃣ subjects

| Column | Type |
|------|------|
| subject_id | INT (PK) |
| subject_name | VARCHAR |

---

#### 4️⃣ marks

| Column | Type |
|------|------|
| student_id | INT |
| subject_id | INT |
| internal | INT |
| external | INT |
| total | INT |
| result_status | VARCHAR |

---

#### 5️⃣ admin

| Column | Type |
|------|------|
| admin_id | INT |
| username | VARCHAR |
| password | VARCHAR |

---

# ▶️ How to Run the Project

## Step 1 — Install XAMPP

Download and install:

https://www.apachefriends.org

Start:

- Apache
- MySQL

---

## Step 2 — Move Project Folder

Copy the project folder into:

```
xampp/htdocs/
```

Example:

```
xampp/htdocs/ssrms
```

---

## Step 3 — Create Database

Open **phpMyAdmin**

```
http://localhost/phpmyadmin
```

Create database:

```
ssms
```

Import the SQL file or create tables manually.

---

## Step 4 — Configure Database

Open:

```
db.php
```

Update credentials if needed:

```php
$conn = mysqli_connect("localhost","root","","ssms");
```

---

## Step 5 — Run Project

Open browser:

```
http://localhost/ssrms
```

---

# 🔐 User Roles

### 👨‍🎓 Student
Login through:

```
student_login.php
```

Capabilities:

- View results
- View performance analytics

---

### 👨‍🏫 Faculty
Login through:

```
faculty_login.php
```

Capabilities:

- Add marks
- Analyze subject performance

---

### 👑 Admin
Login through:

```
admin_login.php
```

Capabilities:

- Monitor complete system
- View students and faculty
- View results and analytics

---

# 📊 Analytics Included

The system provides **real-time academic analytics** using Chart.js.

Charts included:

- Pass vs Fail Pie Chart
- Subject Performance Bar Chart
- Department Distribution Chart
- Student Performance Chart
- Faculty Subject Analysis Chart

---

# 🔒 Security Features

- Session-based authentication
- Role-based dashboards
- Restricted page access
- Logout system

---

# 🎯 Educational Purpose

This project demonstrates:

- Database design
- SQL queries and joins
- Web-based DBMS application
- Role-based system architecture
- Data analytics visualization

Suitable for:

- **B.Tech DBMS projects**
- **Mini projects**
- **Academic demonstrations**

---

# ⭐ Future Improvements

Possible enhancements:

- Password hashing
- Admin CRUD operations
- Student registration system
- Email notifications
- Result PDF generation
- Attendance management
- REST API integration
- Mobile responsive dashboards

---

# 👨‍💻 Author

**Vardhan**

B.Tech — Artificial Intelligence & Machine Learning

Interested in:

- AI / ML Systems
- Computer Architecture
- Data Analytics
- Government Research (ISRO / DRDO)

---

# 📜 License

This project is open-source and available under the **MIT License**.

---

# 🙌 Acknowledgements

- Bootstrap
- Chart.js
- XAMPP
- MySQL
