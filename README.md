# 📚 Library Management System

A **comprehensive web-based Library Management System** built with **PHP** and **MySQL**. This system is designed to **streamline** the management of books, users, and borrowing transactions in any library environment.

---

## 🚀 Features

### 🔐 User Authentication
- Secure login system for **administrators and students**
- **Role-based access control** (admin/student)
- Efficient **session management**

### 👨‍🎓 Student Features
- 🧭 Browse available books
- 📚 Borrow books with **automatic due date assignment**
- 🕒 View personal **borrowing history**

### 🛠️ Admin Features
- 📖 Full book management: **add,view, delete**
- 🧑‍💼 Student account management: **create, delete**
- 📊 Monitor all **borrowed books**
- ⏰ Track **overdue books** with **automatic fine calculation**
- 🔄 Process **book returns**

### 🔒 Security Measures
- 🛡️ SQL injection protection
- 🔄 Proper session handling
- 🔓 Secure logout functionality

---

## 🧰 Tech Stack

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL  

---

## 🗃️ Database Schema

```sql
CREATE DATABASE library;
USE library;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    available BOOLEAN DEFAULT TRUE
);

CREATE TABLE borrowed_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    borrow_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    return_date DATE NULL,
    status ENUM('borrowed', 'returned') DEFAULT 'borrowed',
    FOREIGN KEY (book_id) REFERENCES books(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```
---

## 🔧 Usage

### 👑 Admin Account
To get started, create an admin account 
### 👤 Student Access
- Students can log in using their credentials  
- New student accounts are **created by administrators**

### 🔄 System Workflow

1. 🔐 Login with your role-specific credentials  
2. 👨‍🎓 Students: browse and borrow available books  
3. 👩‍💼 Admins: manage books, students, and monitor all borrowing activities  
4. ⏳ The system automatically tracks **due dates** and **calculates fines** for overdue books  

---

## 🖼️ Screenshots

> ✨ Visual preview of the system in action:
![Picture1](https://github.com/user-attachments/assets/5abae8ea-9a95-43e0-8f5d-c5d91a1e400f)
![Picture2](https://github.com/user-attachments/assets/23a692e8-6169-410b-b5b1-2227f7c3615f)
![Picture3](https://github.com/user-attachments/assets/e444e794-ee39-4dd8-b2ba-7c78d3a73725)
![Picture5](https://github.com/user-attachments/assets/9b90c664-1955-4f6b-aaec-8c9ddd8e7478)
![Picture4](https://github.com/user-attachments/assets/68e71b3a-f190-47e6-a246-4259e6d0d755)


---

## 🚧 Future Enhancements

Here's what's planned for future versions:

- 🤖 AI-based book **recommendation system**
- 📷 Barcode scanning for faster book issuance
- 📱 Mobile application development
- 🔐 Enhanced security with **OAuth-based authentication**
- 📧 Email notifications for **due date reminders**
